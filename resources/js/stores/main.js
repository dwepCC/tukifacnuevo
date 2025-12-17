/**
 * Store principal migrado de Vuex a Pinia
 * Basado en resources/js/store/
 * 
 * En Pinia:
 * - Las mutations se convierten en actions que mutan directamente el state
 * - No hay separación entre mutations y actions
 * - El state es reactivo directamente
 */
import { defineStore } from 'pinia'
import stateData from '../store/state'

// Helper para leer de localStorage
function readStorageData(variable, json = false, defaultv = undefined) {
  let w = localStorage.getItem(variable)
  if (w === 'undefined' && defaultv != undefined) {
    w = defaultv
  }
  if (w === 'undefined') {
    w = null
  }
  if (json === true && w) {
    try {
      w = JSON.parse(w)
    } catch (e) {
      w = defaultv
    }
  }
  return w
}

// Helper para escribir en localStorage
function writeLocal(variable, data) {
  if (data === undefined || data === 'undefined') {
    localStorage.removeItem(variable)
  } else {
    localStorage.setItem(variable, data)
  }
}

export const useMainStore = defineStore('main', {
  // State - Convertido de objeto plano a función que retorna el estado
  state: () => ({ ...stateData }),

  // Getters (opcional, para computed properties del store)
  getters: {
    // Ejemplo: si necesitas computed basados en el state
    // userName: (state) => state.user?.name || 'Sin nombre',
  },

  // Actions - Migrado de Vuex actions y mutations
  // En Pinia, puedes mutar el state directamente en las actions
  actions: {
    // ============================================
    // ACTIONS (cargar datos, inicialización)
    // ============================================

    loadConfiguration() {
      this.config = readStorageData('config', true, this.config)
      this.customers = readStorageData('customers', true, this.customers)
      this.userType = readStorageData('userType', false, this.userType)
      this.company = readStorageData('company', true, this.company)
      this.establishment = readStorageData('establishment', true, this.establishment)
      
      // Inicializar valores undefined
      if (this.deb === undefined) this.deb = {}
      if (this.colors === undefined) this.colors = []
      if (this.CatItemSize === undefined) this.CatItemSize = []
      if (this.CatItemMoldProperty === undefined) this.CatItemMoldProperty = []
      if (this.CatItemUnitBusiness === undefined) this.CatItemUnitBusiness = []
      if (this.CatItemStatus === undefined) this.CatItemStatus = []
      if (this.CatItemProductFamily === undefined) this.CatItemProductFamily = []
      if (this.CatItemPackageMeasurement === undefined) this.CatItemPackageMeasurement = []
      if (this.CatItemUnitsPerPackage === undefined) this.CatItemUnitsPerPackage = []
      if (this.CatItemMoldCavity === undefined) this.CatItemMoldCavity = []
      if (this.extra_colors === undefined) this.extra_colors = []
      if (this.extra_CatItemSize === undefined) this.extra_CatItemSize = []
      if (this.extra_CatItemUnitsPerPackage === undefined) this.extra_CatItemUnitsPerPackage = []
      if (this.extra_CatItemMoldProperty === undefined) this.extra_CatItemMoldProperty = []
      if (this.extra_CatItemUnitBusiness === undefined) this.extra_CatItemUnitBusiness = []
      if (this.extra_CatItemStatus === undefined) this.extra_CatItemStatus = []
      if (this.extra_CatItemPackageMeasurement === undefined) this.extra_CatItemPackageMeasurement = []
      if (this.extra_CatItemMoldCavity === undefined) this.extra_CatItemMoldCavity = []
      if (this.extra_CatItemProductFamily === undefined) this.extra_CatItemProductFamily = []
      if (this.loading_submit === undefined) this.loading_submit = false
      if (this.payment_method_types === undefined) this.payment_method_types = []
      if (this.form_pos === undefined) this.form_pos = {}
      if (this.currency_types === undefined) this.currency_types = []
      if (this.items === undefined) this.items = []
      if (this.exchange_rate_sale === undefined) this.exchange_rate_sale = 1
      if (this.exchange_rate === undefined) this.exchange_rate = 1
      if (this.item === undefined) this.item = {}
      if (this.document_types_guide === undefined) this.document_types_guide = {}
      if (this.form_data === undefined) this.form_data = {}
      if (this.resource === undefined) this.resource = ''
      if (this.periods === undefined) this.periods = []
      if (this.affectation_igv_types === undefined) this.affectation_igv_types = []
      if (this.table_data === undefined) this.table_data = []
      if (this.unit_types === undefined) this.unit_types = []
      if (this.item_search_extra_parameters === undefined) this.item_search_extra_parameters = {}
      if (this.person === undefined) this.person = {}
      if (this.customers === undefined) this.customers = []
      if (this.countries === undefined) this.countries = []
      if (this.all_departments === undefined) this.all_departments = []
      if (this.all_provinces === undefined) this.all_provinces = []
      if (this.all_districts === undefined) this.all_districts = []
      if (this.identity_document_types === undefined) this.identity_document_types = []
      if (this.locations === undefined) this.locations = []
      if (this.person_types === undefined) this.person_types = []
      if (this.all_series === undefined) this.all_series = []
      if (this.series === undefined) this.series = []
      if (this.payment_destinations === undefined) this.payment_destinations = []
      if (this.statusDocumentary === undefined) this.statusDocumentary = []
      if (this.parent_customer === undefined) this.parent_customer = {}
      if (this.children_customer === undefined) this.children_customer = {}
      if (this.customer_addresses === undefined) this.customer_addresses = []
      if (this.parentPerson === undefined) this.parentPerson = {}
      
      if (this.mi_tienda_pe === undefined) {
        this.mi_tienda_pe = {
          establishment_id: null,
          series_order_note_id: null,
          autogenerate: false,
          series_document_id: null,
          user_id: null,
          payment_destination_id: null,
          currency_type_id: 'PEN',
        }
      }
    },

    EmitEvent(event, payload) {
      // Esto se manejará con eventBus
      // Se puede usar: import { eventBus } from '@/helpers/compat'
      // eventBus.emit(event, payload)
    },

    clearFormData() {
      this.form_data = {}
    },

    clearExtraInfoItem() {
      this.extra_colors = []
      this.extra_CatItemSize = []
      this.extra_CatItemUnitsPerPackage = []
      this.extra_CatItemMoldProperty = []
      this.extra_CatItemUnitBusiness = []
      this.extra_CatItemStatus = []
      this.extra_CatItemPackageMeasurement = []
      this.extra_CatItemMoldCavity = []
      this.extra_CatItemProductFamily = []
    },

    loadWarehouses() {
      if (this.warehouses === undefined) this.warehouses = []
    },

    loadOffices() {
      if (this.offices === undefined) this.offices = []
    },

    loadStatusDocumentary() {
      if (this.statusDocumentary === undefined) this.statusDocumentary = []
    },

    loadCustomers() {
      if (this.customers === undefined) this.customers = []
    },

    loadCurrencys() {
      if (this.currencys === undefined) this.currencys = []
    },

    loadActions() {
      if (this.actions === undefined) this.actions = []
    },

    loadProcesses() {
      if (this.processes === undefined) this.processes = []
    },

    loadFiles() {
      if (this.files === undefined) this.files = []
    },

    loadCurrencyTypes() {
      if (this.currency_types === undefined) this.currency_types = []
    },

    loadDocumentTypes() {
      this.documentTypes = readStorageData('documentTypes', true) || []
    },

    loadWorkers() {
      if (this.workers === undefined) this.workers = []
    },

    loadPos() {
      this.form_pos = readStorageData('form_pos', true) || {}
      if (this.form_pos === undefined) this.form_pos = {}
    },

    loadAllItems() {
      if (this.all_items === undefined) this.all_items = []
    },

    loadItem() {
      if (this.item === undefined) this.item = {}
    },

    loadItems() {
      if (this.items === undefined) this.items = []
    },

    loadExchangeRate() {
      if (this.exchange_rate === undefined) this.exchange_rate = 1
    },

    loadDocumentTypesGuide() {
      if (this.document_types_guide === undefined) this.document_types_guide = []
    },

    loadExchangeRateSale() {
      if (this.exchange_rate_sale === undefined) this.exchange_rate_sale = 1
    },

    loadHasGlobalIgv() {
      if (this.hasGlobalIgv === undefined) this.hasGlobalIgv = false
    },

    loadCompany() {
      let t = readStorageData('company', true)
      if (t !== null) {
        this.company = t
      } else {
        this.company = {
          logo: null,
          name: '',
        }
      }
    },

    loadEstablishment() {
      let t = readStorageData('establishment', true)
      if (t !== null) {
        this.establishment = t
      } else {
        this.establishment = {
          address: '-',
          district: { description: '' },
          province: { description: '' },
          department: { description: '' },
          country: { description: '' },
          telephone: '-',
          email: null,
        }
      }
    },

    // ============================================
    // MUTATIONS MIGRADAS (ahora son actions)
    // ============================================

    // Configuration
    setConfiguration(config) {
      if (config !== undefined && config.company !== undefined) {
        this.company = config.company
        writeLocal('company', JSON.stringify(config.company))
      }
      if (config !== undefined && config.establishment !== undefined) {
        this.establishment = config.establishment
        writeLocal('establishment', JSON.stringify(config.establishment))
      }
      this.config = config
      if (config === undefined) {
        this.config = JSON.parse(localStorage.getItem('config') || '{}')
        config = this.config
      }
      writeLocal('config', JSON.stringify(config))
    },

    setEstablishment(establishment) {
      writeLocal('establishment', JSON.stringify(establishment))
      this.establishment = establishment
      return establishment
    },

    setCompany(company) {
      writeLocal('company', JSON.stringify(company))
      this.company = company
      return company
    },

    // Customers
    setCustomers(customers) {
      this.customers = (customers === undefined) ? [] : customers
    },

    setCustomer(customer) {
      this.customer = (customer === undefined) ? {} : customer
    },

    setParentCustomer(parent_customer) {
      this.parent_customer = (parent_customer === undefined) ? {} : parent_customer
    },

    setChildrenCustomer(children_customer) {
      this.children_customer = (children_customer === undefined) ? {} : children_customer
    },

    setAllCustomers(all_customers) {
      this.all_customers = (all_customers === undefined) ? [] : all_customers
    },

    setCustomersAddresses(customer_addresses) {
      this.customer_addresses = (customer_addresses === undefined) ? [] : customer_addresses
    },

    setPlans(plans) {
      this.plans = (plans === undefined) ? [] : plans
    },

    // Exchange Rates
    setExchangeRate(exchange_rate) {
      this.exchange_rate = exchange_rate
    },

    setExchangeRateSale(exchange_rate_sale) {
      this.exchange_rate_sale = exchange_rate_sale
    },

    setCurrencys(currencys) {
      this.currencys = currencys
    },

    // Offices
    setOffices(offices) {
      this.offices = offices
    },

    setOffice(office) {
      this.office = office
    },

    // Documents
    setDocumentTypes(documentTypes) {
      this.documentTypes = documentTypes
      writeLocal('documentTypes', JSON.stringify(documentTypes))
    },

    setDocumentTypesGuide(document_types_guide) {
      if (document_types_guide === undefined) document_types_guide = {}
      this.document_types_guide = document_types_guide
    },

    // Files
    setFiles(files) {
      this.files = files
    },

    setFile(file) {
      this.file = file
    },

    // Processes
    setProcesses(processes) {
      this.processes = processes
    },

    // Actions
    setActions(actions) {
      this.actions = actions
    },

    // UI State
    canShowColorDialog(showColorDialog) {
      this.showColorDialog = showColorDialog
    },

    setColor(color) {
      this.color = color
    },

    setLoadingSubmit(loading_submit) {
      if (loading_submit === undefined) loading_submit = false
      this.loading_submit = loading_submit
    },

    // Workers
    setWorkers(workers) {
      this.workers = workers
    },

    // Colors & Categories
    setColors(colors) {
      if (colors === undefined) colors = []
      this.colors = colors
    },

    setCatItemStatus(CatItemStatus) {
      if (CatItemStatus === undefined) CatItemStatus = []
      this.CatItemStatus = CatItemStatus
    },

    setCatItemUnitsPerPackage(CatItemUnitsPerPackage) {
      if (CatItemUnitsPerPackage === undefined) CatItemUnitsPerPackage = []
      this.CatItemUnitsPerPackage = CatItemUnitsPerPackage
    },

    setCatItemMoldCavity(CatItemMoldCavity) {
      if (CatItemMoldCavity === undefined) CatItemMoldCavity = []
      this.CatItemMoldCavity = CatItemMoldCavity
    },

    setCatItemSize(CatItemSize) {
      if (CatItemSize === undefined) CatItemSize = []
      this.CatItemSize = CatItemSize
    },

    setCatItemMoldProperty(CatItemMoldProperty) {
      if (CatItemMoldProperty === undefined) CatItemMoldProperty = []
      this.CatItemMoldProperty = CatItemMoldProperty
    },

    setCatItemUnitBusiness(CatItemUnitBusiness) {
      if (CatItemUnitBusiness === undefined) CatItemUnitBusiness = []
      this.CatItemUnitBusiness = CatItemUnitBusiness
    },

    setCatItemPackageMeasurement(CatItemPackageMeasurement) {
      if (CatItemPackageMeasurement === undefined) CatItemPackageMeasurement = []
      this.CatItemPackageMeasurement = CatItemPackageMeasurement
    },

    setCatItemProductFamily(CatItemProductFamily) {
      if (CatItemProductFamily === undefined) CatItemProductFamily = []
      this.CatItemProductFamily = CatItemProductFamily
    },

    // Extra Categories
    setExtraColors(extra_colors) {
      if (extra_colors === undefined) extra_colors = []
      this.extra_colors = extra_colors
    },

    setExtraCatItemUnitsPerPackage(extra_CatItemUnitsPerPackage) {
      if (extra_CatItemUnitsPerPackage === undefined) extra_CatItemUnitsPerPackage = []
      this.extra_CatItemUnitsPerPackage = extra_CatItemUnitsPerPackage
    },

    setExtraCatItemSize(extra_CatItemSize) {
      if (extra_CatItemSize === undefined) extra_CatItemSize = []
      this.extra_CatItemSize = extra_CatItemSize
    },

    setExtraCatItemMoldProperty(extra_CatItemMoldProperty) {
      if (extra_CatItemMoldProperty === undefined) extra_CatItemMoldProperty = []
      this.extra_CatItemMoldProperty = extra_CatItemMoldProperty
    },

    setExtraCatItemUnitBusiness(extra_CatItemUnitBusiness) {
      if (extra_CatItemUnitBusiness === undefined) extra_CatItemUnitBusiness = []
      this.extra_CatItemUnitBusiness = extra_CatItemUnitBusiness
    },

    setExtraCatItemStatus(extra_CatItemStatus) {
      if (extra_CatItemStatus === undefined) extra_CatItemStatus = []
      this.extra_CatItemStatus = extra_CatItemStatus
    },

    setExtraCatItemPackageMeasurement(extra_CatItemPackageMeasurement) {
      if (extra_CatItemPackageMeasurement === undefined) extra_CatItemPackageMeasurement = []
      this.extra_CatItemPackageMeasurement = extra_CatItemPackageMeasurement
    },

    setExtraCatItemMoldCavity(extra_CatItemMoldCavity) {
      if (extra_CatItemMoldCavity === undefined) extra_CatItemMoldCavity = []
      this.extra_CatItemMoldCavity = extra_CatItemMoldCavity
    },

    setExtraCatItemProductFamily(extra_CatItemProductFamily) {
      if (extra_CatItemProductFamily === undefined) extra_CatItemProductFamily = []
      this.extra_CatItemProductFamily = extra_CatItemProductFamily
    },

    // Form Data
    setDeb(debug) {
      if (debug === undefined) debug = {}
      this.deb = debug
    },

    setFormData(form_data) {
      if (form_data === undefined) form_data = {}
      this.form_data = form_data
    },

    setPeriods(periods) {
      if (periods === undefined) periods = []
      this.periods = periods
    },

    setFilter(filter) {
      if (filter === undefined) filter = []
      this.filter = filter
    },

    setFromPos(form_pos) {
      if (form_pos === undefined) form_pos = {}
      writeLocal('form_pos', JSON.stringify(form_pos))
      this.form_pos = form_pos
    },

    setPaymentMethodTypes(payment_method_types) {
      this.payment_method_types = (payment_method_types === undefined) ? [] : payment_method_types
    },

    setPaymentDestinations(payment_destinations) {
      this.payment_destinations = (payment_destinations === undefined) ? [] : payment_destinations
    },

    // Items
    setRecords(records) {
      if (records === undefined) records = []
      this.records = records
    },

    setItems(items) {
      if (items === undefined) items = []
      this.items = items
    },

    setItem(item) {
      this.item = (item === undefined) ? {} : item
    },

    setAllItems(all_items) {
      if (this.all_items !== undefined) {
        let temp_item = [this.all_items, ...all_items]
        temp_item = temp_item.filter((item, index, self) =>
          index === self.findIndex((t) => (t.id === item.id))
        )
        this.all_items = temp_item
      } else {
        this.all_items = all_items
      }
    },

    setMiTiendaPe(mi_tienda_pe) {
      this.mi_tienda_pe = (mi_tienda_pe === undefined) ? {
        establishment_id: null,
        series_order_note_id: null,
        series_document_id: null,
        user_id: null,
        payment_destination_id: null,
        currency_type_id: null,
      } : mi_tienda_pe
    },

    setTableData(table_data) {
      this.table_data = (table_data === undefined) ? [] : table_data
    },

    setPagination(pagination) {
      if (pagination === undefined) pagination = {
        current_page: 1,
        total: 0,
        per_page: 25,
      }
      this.pagination = pagination
    },

    setTypeUser(userType) {
      this.userType = userType
      writeLocal('userType', userType)
    },

    setWarehouses(warehouses) {
      this.warehouses = warehouses
    },

    setResource(resource) {
      this.resource = resource
    },

    setItemSearchExtraParameters(item_search_extra_parameters) {
      if (item_search_extra_parameters === undefined) item_search_extra_parameters = {}
      this.item_search_extra_parameters = item_search_extra_parameters
    },

    setPerson(person) {
      if (person === undefined) person = {}
      this.person = person
    },

    setParentPerson(parentPerson) {
      if (parentPerson === undefined) parentPerson = {}
      this.parentPerson = parentPerson
    },

    sethasGlobalIgv(hasGlobalIgv) {
      if (hasGlobalIgv === undefined) hasGlobalIgv = false
      this.hasGlobalIgv = hasGlobalIgv
    },

    setEnabledGlobalIgvToPurchase(enabled_global_igv_to_purchase) {
      if (enabled_global_igv_to_purchase === undefined) enabled_global_igv_to_purchase = false
      if (this.config) {
        this.config.enabled_global_igv_to_purchase = enabled_global_igv_to_purchase
      }
    },

    setCurrencyTypes(currency_types) {
      if (currency_types === undefined) currency_types = []
      this.currency_types = currency_types
    },

    setAffectationIgvTypes(affectation_igv_types) {
      if (affectation_igv_types === undefined) affectation_igv_types = []
      this.affectation_igv_types = affectation_igv_types
    },

    setUnitTypes(unit_types) {
      this.unit_types = (unit_types === undefined) ? [] : unit_types
    },

    // Locations
    setCountries(countries) {
      this.countries = (countries === undefined) ? [] : countries
    },

    setAllDepartments(all_departments) {
      this.all_departments = (all_departments === undefined) ? [] : all_departments
    },

    setAllProvinces(all_provinces) {
      this.all_provinces = (all_provinces === undefined) ? [] : all_provinces
    },

    setAllDistricts(all_districts) {
      this.all_districts = (all_districts === undefined) ? [] : all_districts
    },

    setIdentityDocumentTypes(identity_document_types) {
      this.identity_document_types = (identity_document_types === undefined) ? [] : identity_document_types
    },

    setLocations(locations) {
      this.locations = (locations === undefined) ? [] : locations
    },

    setPersonTypes(person_types) {
      this.person_types = (person_types === undefined) ? [] : person_types
    },

    // Series
    setSeries(series) {
      this.series = (series === undefined) ? [] : series
    },

    setAllSeries(all_series) {
      this.all_series = (all_series === undefined) ? [] : all_series
    },

    // Sellers
    setSellers(sellers) {
      this.sellers = (sellers === undefined) ? [] : sellers
    },

    // Status Documentary
    setStatusDocumentary(statusDocumentary) {
      this.statusDocumentary = (statusDocumentary === undefined) ? [] : statusDocumentary
    },
  },
})
