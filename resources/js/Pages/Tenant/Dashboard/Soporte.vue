<template>
  <TenantLayout title="Tutoriales">
    <div class="tutorial-container">
      <div class="section-header">
        <div class="section-header-content">
          <h2><i class="fas fa-graduation-cap"></i> Centro de Aprendizaje</h2>
          <p>Domina nuestro sistema de facturación electrónica con tutoriales paso a paso</p>
        </div>
      </div>
      
      <div class="search-container">
        <div class="search-box">
          <i class="fas fa-search"></i>
          <input 
            type="text" 
            v-model="searchTerm"
            placeholder="Buscar tutoriales..." 
            @input="filterTutorials"
          />
        </div>
      </div>
            
      <div class="tutorial-columns" ref="tutorialColumns">
        <div v-if="filteredCategories.length === 0" class="text-center py-8 text-gray-500">
          <p>No se encontraron tutoriales.</p>
        </div>
        <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
          <div v-for="category in filteredCategories" :key="category.id" class="tutorial-category">
            <div class="category-header">
              <h3><i :class="category.icon"></i> {{ category.title }}</h3>
              <span class="category-count">{{ category.videos.length }}</span>
            </div>
            <div class="video-list">
              <div 
                v-for="video in category.videos" 
                :key="video.id"
                class="video-item"
                @click="openVideoModal(video.url, video.title, `Tutorial sobre ${video.title}`)"
              >
                <div class="video-thumbnail">
                  <img :src="video.thumbnail" :alt="video.title" />
                  <div class="video-duration">{{ video.duration }}</div>
                </div>
                <div class="video-info">
                  <div class="video-title">{{ video.title }}</div>
                  <div class="video-meta">
                    <span>{{ formatViews(video.views) }} vistas</span>
                    <span>{{ formatDate(video.publishedDate) }}</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!-- Modal para reproducir videos -->
      <div 
        v-show="showModal"
        id="videoModal" 
        class="modal"
        @click.self="closeModal"
      >
        <div class="modal-content">
          <span class="close" @click="closeModal">&times;</span>
          <div class="video-container">
            <iframe 
              id="videoPlayer" 
              width="100%" 
              height="400" 
              :src="currentVideoUrl" 
              frameborder="0" 
              allowfullscreen
            ></iframe>
          </div>
          <div class="video-info-modal">
            <h3>{{ currentVideoTitle }}</h3>
            <p>{{ currentVideoDescription }}</p> 
          </div>
        </div>
      </div>
    </div>
  </TenantLayout>
</template>

<script setup>
import { ref, computed } from 'vue'
import TenantLayout from '@/Layouts/TenantLayout.vue'

defineProps({
  soap_company: {
    type: String,
    default: null
  },
  configuration: {
    type: Object,
    default: () => ({})
  },
  type_user: {
    type: String,
    default: ''
  }
})

const searchTerm = ref('')
const showModal = ref(false)
const currentVideoUrl = ref('')
const currentVideoTitle = ref('')
const currentVideoDescription = ref('')

// Datos de tutoriales - Versión simplificada
// TODO: Cargar desde API o archivo de configuración
const tutorialCategories = ref([
  {
    id: 1,
    title: "Primeros pasos",
    icon: "fas fa-play-circle",
    videos: [
      { 
        id: 1, 
        title: "Ubicación de herramientas",
        url: "https://www.youtube.com/watch?v=F8a7q0irX0A",
        thumbnail: "https://img.youtube.com/vi/F8a7q0irX0A/mqdefault.jpg",
        duration: "1:10",
        views: 1250,
        publishedDate: "2025-10-14"
      },
      { 
        id: 2, 
        title: "Cómo actualizo los datos de mi comprobante",
        url: "https://www.youtube.com/watch?v=Re9BssDPli0",
        thumbnail: "https://img.youtube.com/vi/Re9BssDPli0/mqdefault.jpg",
        duration: "1:33",
        views: 890,
        publishedDate: "2025-10-14"
      },
      { 
        id: 3, 
        title: "Cómo usar el dashboard",
        url: "https://www.youtube.com/watch?v=oxT_aAeQTGk",
        thumbnail: "https://img.youtube.com/vi/oxT_aAeQTGk/mqdefault.jpg",
        duration: "1:43",
        views: 2100,
        publishedDate: "2025-10-14"
      }
    ]
  }
])

const filteredCategories = computed(() => {
  if (!searchTerm.value) {
    return tutorialCategories.value
  }
  
  const term = searchTerm.value.toLowerCase()
  return tutorialCategories.value.map(category => ({
    ...category,
    videos: category.videos.filter(video => 
      video.title.toLowerCase().includes(term)
    )
  })).filter(category => category.videos.length > 0)
})

const closeModal = () => {
  showModal.value = false
  currentVideoUrl.value = ''
}

const openVideoModal = (videoUrl, title, description) => {
  let embedUrl = videoUrl
  if (videoUrl.includes('youtu.be') || videoUrl.includes('youtube.com')) {
    const videoId = videoUrl.match(/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/)
    if (videoId && videoId[1]) {
      embedUrl = `https://www.youtube.com/embed/${videoId[1]}?autoplay=1`
    }
  }
  
  currentVideoUrl.value = embedUrl
  currentVideoTitle.value = title
  currentVideoDescription.value = description
  showModal.value = true
}

const formatViews = (views) => {
  const num = parseInt(views)
  if (num >= 1000000) {
    return (num / 1000000).toFixed(1) + 'M'
  } else if (num >= 1000) {
    return (num / 1000).toFixed(1) + 'K'
  }
  return num.toString()
}

const formatDate = (publishedDate) => {
  const date = new Date(publishedDate)
  const now = new Date()
  const diffTime = Math.abs(now - date)
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24))
  
  if (diffDays < 7) {
    return `Hace ${diffDays} día${diffDays > 1 ? 's' : ''}`
  } else if (diffDays < 30) {
    const weeks = Math.floor(diffDays / 7)
    return `Hace ${weeks} semana${weeks > 1 ? 's' : ''}`
  } else if (diffDays < 365) {
    const months = Math.floor(diffDays / 30)
    return `Hace ${months} mes${months > 1 ? 'es' : ''}`
  } else {
    const years = Math.floor(diffDays / 365)
    return `Hace ${years} año${years > 1 ? 's' : ''}`
  }
}
</script>

<style scoped>
.tutorial-container {
  width: 100%;
  padding: 2rem;
}

.section-header {
  margin-bottom: 2rem;
}

.section-header-content h2 {
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.search-container {
  margin-bottom: 2rem;
}

.search-box {
  position: relative;
  max-width: 500px;
}

.search-box i {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #6b7280;
}

.search-box input {
  width: 100%;
  padding: 0.75rem 1rem 0.75rem 3rem;
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  font-size: 1rem;
}

.tutorial-category {
  background: white;
  border-radius: 0.5rem;
  padding: 1.5rem;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
}

.category-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #e5e7eb;
}

.category-header h3 {
  font-size: 1.125rem;
  font-weight: 600;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.category-count {
  background: #3b82f6;
  color: white;
  padding: 0.25rem 0.75rem;
  border-radius: 9999px;
  font-size: 0.875rem;
}

.video-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.video-item {
  display: flex;
  gap: 1rem;
  cursor: pointer;
  padding: 0.75rem;
  border-radius: 0.5rem;
  transition: background-color 0.2s;
}

.video-item:hover {
  background-color: #f3f4f6;
}

.video-thumbnail {
  position: relative;
  width: 120px;
  height: 90px;
  flex-shrink: 0;
  border-radius: 0.375rem;
  overflow: hidden;
}

.video-thumbnail img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.video-duration {
  position: absolute;
  bottom: 0.25rem;
  right: 0.25rem;
  background-color: rgba(0, 0, 0, 0.8);
  color: white;
  padding: 0.125rem 0.375rem;
  border-radius: 0.25rem;
  font-size: 0.75rem;
  font-weight: 600;
}

.video-info {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
}

.video-title {
  font-weight: 600;
  margin-bottom: 0.5rem;
  line-height: 1.4;
}

.video-meta {
  font-size: 0.875rem;
  color: #6b7280;
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
}

.modal {
  display: block;
  position: fixed;
  z-index: 1000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: #fff;
  margin: 5% auto;
  padding: 2rem;
  border-radius: 0.5rem;
  max-width: 900px;
  width: 90%;
  position: relative;
}

.close {
  color: #aaa;
  position: absolute;
  right: 1rem;
  top: 1rem;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
  z-index: 10;
}

.close:hover {
  color: #000;
}

.video-container {
  margin-bottom: 1rem;
  position: relative;
  padding-bottom: 56.25%;
  height: 0;
  overflow: hidden;
}

.video-container iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}

.video-info-modal h3 {
  margin-bottom: 0.5rem;
  font-size: 1.25rem;
  font-weight: 600;
}

.video-info-modal p {
  color: #6b7280;
}
</style>

