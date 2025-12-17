/*
Template Name: Admin Pro Admin
Author: Wrappixel
Email: niravjoshi87@gmail.com
File: js
*/
import './sidebarmenu';

// Función para inicializar cuando jQuery esté disponible
function initCustom() {
    // Asegurar que jQuery esté disponible desde window
    // En módulos ES6, $ no está disponible globalmente, debe accederse desde window
    const $ = window.$ || window.jQuery;
    const jQuery = window.jQuery || window.$;

    if (!$) {
        // Reintentar después de un breve delay
        setTimeout(initCustom, 50);
        return;
    }

    // Ejecutar código cuando jQuery esté disponible
    $(function() {
    "use strict";
    try {
        $(function() {
            $(".preloader").fadeOut();
        });
    jQuery(document).on('click', '.mega-dropdown', function(e) {
        e.stopPropagation()
    });
    // ==============================================================
    // This is for the top header part and sidebar part
    // ==============================================================
    var set = function() {
        var width = (window.innerWidth > 0) ? window.innerWidth : this.screen.width;
        var topOffset = 0;
        if (width < 1170) {
            $("body").addClass("mini-sidebar");
            $('.navbar-brand span').hide();
            $(".sidebartoggler i").addClass("ti-menu");
        } else {
            $("body").removeClass("mini-sidebar");
            $('.navbar-brand span').show();
        }

        var height = ((window.innerHeight > 0) ? window.innerHeight : this.screen.height) - 1;
        height = height - topOffset;
        if (height < 1) height = 1;
        if (height > topOffset) {
            $(".page-wrapper").css("min-height", (height) + "px");
        }

    };
    $(window).ready(set);
    $(window).on("resize", set);

    // ==============================================================
    // Theme options
    // ==============================================================
    $(".sidebartoggler").on('click', function() {
        if ($("body").hasClass("mini-sidebar")) {
            $("body").trigger("resize");
            $("body").removeClass("mini-sidebar");
            $('.navbar-brand span').show();

        } else {
            $("body").trigger("resize");
            $("body").addClass("mini-sidebar");
            $('.navbar-brand span').hide();

        }
    });

    // this is for close icon when navigation open in mobile view
    $(".nav-toggler").click(function() {
        $("body").toggleClass("show-sidebar");
        $(".nav-toggler i").toggleClass("ti-menu");
        $(".nav-toggler i").addClass("ti-close");
    });

    $(".search-box a, .search-box .app-search .srh-btn").on('click', function() {
        $(".app-search").toggle(200);
    });
    // ==============================================================
    // Right sidebar options
    // ==============================================================
    $(".right-side-toggle").click(function() {
        $(".right-sidebar").slideDown(50);
        $(".right-sidebar").toggleClass("shw-rside");
    });
    // ==============================================================
    // This is for the floating labels
    // ==============================================================
    $('.floating-labels .form-control').on('focus blur', function(e) {
        $(this).parents('.form-group').toggleClass('focused', (e.type === 'focus' || this.value.length > 0));
    }).trigger('blur');

    // ==============================================================
    // Auto select left navbar
    // ==============================================================
    $(function() {
        var url = window.location;
        var element = $('ul#sidebarnav a').filter(function() {
            return this.href == url;
        }).addClass('active').parent().addClass('active');
        while (true) {
            if (element.is('li')) {
                element = element.parent().addClass('in').parent().addClass('active');
            } else {
                break;
            }
        }

    });
    // ==============================================================
    //tooltip (solo si Bootstrap JS está disponible)
    // Comentado porque no se usa Bootstrap - usar el-tooltip de Element Plus en su lugar
    // ==============================================================
    // $(function() {
    //     if (typeof $.fn.tooltip === 'function') {
    //         $('[data-toggle="tooltip"]').tooltip()
    //     }
    // })
    
    // ==============================================================
    //Popover (solo si Bootstrap JS está disponible)
    // Comentado porque no se usa Bootstrap - usar el-popover de Element Plus en su lugar
    // ==============================================================
    // $(function() {
    //     if (typeof $.fn.popover === 'function') {
    //         $('[data-toggle="popover"]').popover()
    //     }
    // })
    // ==============================================================
    // Sidebarmenu - ELIMINADO: Ya no se usa el sidebar antiguo con AdminMenu
    // El nuevo sidebar usa Vue 3 con TenantSidebar.vue
    // ==============================================================

    // ==============================================================
    // Perfect scrollbar (solo si el plugin está disponible)
    // ==============================================================
    // Verificar si el plugin está disponible antes de usarlo
    if (typeof $.fn.perfectScrollbar === 'function') {
        try {
            $('.scroll-sidebar, .right-side-panel, .message-center, .right-sidebar').perfectScrollbar();
        } catch (e) {
            // Ignorar error si hay problemas al inicializar perfectScrollbar
        }
    }
    // Si no está disponible, simplemente no hacer nada (no es crítico)

    // ==============================================================
    // Resize all elements
    // ==============================================================
    $("body").trigger("resize");
    // ==============================================================
    // To do list
    // ==============================================================
    $(".list-task li label").click(function() {
        $(this).toggleClass("task-done");
    });



    // ==============================================================
    // Collapsable cards
    // ==============================================================
    try {
        $('a[data-action="collapse"]').on('click', function(e) {
            e.preventDefault();
            $(this).closest('.card').find('[data-action="collapse"] i').toggleClass('ti-minus ti-plus');
            // Usar toggleClass de jQuery en lugar de collapse de Bootstrap
            $(this).closest('.card').children('.card-body').slideToggle();
        });
    } catch (e) {
        // Ignorar error si hay problemas con los cards
    }
    // Toggle fullscreen
    $('a[data-action="expand"]').on('click', function(e) {
        e.preventDefault();
        $(this).closest('.card').find('[data-action="expand"] i').toggleClass('mdi-arrow-expand mdi-arrow-compress');
        $(this).closest('.card').toggleClass('card-fullscreen');
    });

    // Close Card
    $('a[data-action="close"]').on('click', function() {
        $(this).closest('.card').removeClass().slideUp('fast');
    });
    } catch (e) {
        // Si hay algún error en el código de custom.js, solo loguearlo pero no romper la aplicación
        console.warn('Error en custom.js (no crítico):', e);
    }

    });
}

// Iniciar cuando el módulo se carga
// Si jQuery ya está disponible, ejecutar inmediatamente
if (window.$ || window.jQuery) {
    initCustom();
} else {
    // Si no está disponible, esperar a que el DOM esté listo
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initCustom);
    } else {
        // DOM ya está listo, pero jQuery puede no estar disponible aún
        setTimeout(initCustom, 100);
    }
}