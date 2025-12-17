<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Set the root template based on the route.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string
     */
    public function rootView(Request $request): string
    {
        // Si la ruta es del sistema (superadmin), usar layout de sistema
        if ($request->routeIs('system.*') || $request->is('*system*') || $request->is('system*')) {
            return 'system-app';
        }

        // Si la ruta es del tenant, usar layout de tenant
        // Detectar por nombre de ruta, path, o tipo de usuario
        $isTenantRoute = $request->routeIs('tenant.*') || 
                        $request->is('tenant*') ||
                        ($request->user() && 
                         $request->user()->type !== 'admin' && 
                         !$request->is('*system*') && 
                         !$request->is('system*') &&
                         !$request->is('login') &&
                         !$request->is('register') &&
                         !$request->is('password/*') &&
                         !$request->is('email/*'));
        
        if ($isTenantRoute) {
            return 'tenant-app';
        }

        return parent::rootView($request);
    }

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'auth' => [
                'user' => $request->user(),
            ],
            'configuration' => function () use ($request) {
                if ($request->routeIs('system.*')) {
                    try {
                        $config = \App\Models\System\Configuration::first();
                        return $config ? [
                            'login' => $config->login ?? null,
                            'multi_user_enabled' => config('configuration.multi_user_enabled', false),
                        ] : null;
                    } catch (\Exception $e) {
                        return null;
                    }
                }
                return null;
            },
            // Datos compartidos para tenant
            'vc_modules' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    return $this->getTenantModules($request);
                }
                return [];
            },
            'vc_module_levels' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    return $this->getTenantModuleLevels($request);
                }
                return [];
            },
            'vc_company' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    try {
                        return \App\Models\Tenant\Company::first();
                    } catch (\Exception $e) {
                        return null;
                    }
                }
                return null;
            },
            'vc_configuration' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    try {
                        return \App\Models\Tenant\Configuration::first();
                    } catch (\Exception $e) {
                        return null;
                    }
                }
                return null;
            },
            'vc_user' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    return $request->user();
                }
                return null;
            },
            'vc_orders' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    try {
                        return \App\Models\Tenant\Order::where('status_order_id', 1)->count();
                    } catch (\Exception $e) {
                        return 0;
                    }
                }
                return 0;
            },
            'vc_document' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    try {
                        return \App\Models\Tenant\Document::whereNotSent()->count();
                    } catch (\Exception $e) {
                        return 0;
                    }
                }
                return 0;
            },
            'vc_document_regularize_shipping' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    try {
                        return \App\Models\Tenant\Document::whereRegularizeShipping()->count();
                    } catch (\Exception $e) {
                        return 0;
                    }
                }
                return 0;
            },
            'vc_finished_downloads' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    try {
                        return \App\Models\Tenant\DownloadTray::whereDate('created_at', \Carbon\Carbon::today())
                            ->where('status', 'FINISHED')
                            ->count();
                    } catch (\Exception $e) {
                        return 0;
                    }
                }
                return 0;
            },
            'tenant_show_ads' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    try {
                        $systemConfig = \App\Models\System\Configuration::getDataModuleViewComposer();
                        return $systemConfig->tenant_show_ads ?? false;
                    } catch (\Exception $e) {
                        return false;
                    }
                }
                return false;
            },
            'url_tenant_image_ads' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    try {
                        $systemConfig = \App\Models\System\Configuration::getDataModuleViewComposer();
                        return $systemConfig->getUrlTenantImageAds();
                    } catch (\Exception $e) {
                        return null;
                    }
                }
                return null;
            },
            'inventory_configuration' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    try {
                        $config = \Modules\Inventory\Models\InventoryConfiguration::select('inventory_review')->first();
                        return $config ? ['inventory_review' => $config->inventory_review ?? false] : ['inventory_review' => false];
                    } catch (\Exception $e) {
                        return ['inventory_review' => false];
                    }
                }
                return ['inventory_review' => false];
            },
            'support_user' => function () use ($request) {
                if ($this->isTenantRoute($request)) {
                    try {
                        $supportUser = \App\Models\System\User::first();
                        if ($supportUser && ($supportUser->phone || $supportUser->whatsapp_number || $supportUser->address_contact)) {
                            return $supportUser;
                        }
                        return null;
                    } catch (\Exception $e) {
                        return null;
                    }
                }
                return null;
            },
        ]);
    }

    /**
     * Check if the request is for a tenant route
     */
    protected function isTenantRoute(Request $request): bool
    {
        // Detectar rutas del tenant de múltiples formas
        if ($request->routeIs('tenant.*') || $request->is('tenant*')) {
            return true;
        }
        
        // Si hay un usuario autenticado y no es admin, y no es una ruta del sistema
        if ($request->user() && 
            $request->user()->type !== 'admin' && 
            !$request->is('*system*') && 
            !$request->is('system*') &&
            !$request->is('login') &&
            !$request->is('register') &&
            !$request->is('password/*') &&
            !$request->is('email/*')) {
            return true;
        }
        
        return false;
    }

    /**
     * Get tenant modules
     */
    protected function getTenantModules(Request $request): array
    {
        try {
            $user = $request->user();
            if (!$user) {
                return [];
            }

            $modules = $user->modules()->pluck('value')->toArray();
            if (count($modules) > 0) {
                return $modules;
            }

            return \App\Models\Tenant\Module::all()->pluck('value')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }

    /**
     * Get tenant module levels
     */
    protected function getTenantModuleLevels(Request $request): array
    {
        try {
            $user = $request->user();
            if (!$user) {
                return [];
            }

            $module_levels = $user->levels()->pluck('value')->toArray();
            if (count($module_levels) > 0) {
                return $module_levels;
            }

            return \Modules\LevelAccess\Models\ModuleLevel::all()->pluck('value')->toArray();
        } catch (\Exception $e) {
            return [];
        }
    }
}
