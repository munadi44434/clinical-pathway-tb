<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
          <div>
            <h1 class="text-3xl font-bold text-gray-900">Detail Clinical Pathway</h1>
            <p class="mt-1 text-sm text-gray-500">
              Pasien: {{ patient.name }} (NIK: {{ patient.nik }})
            </p>
          </div>
          <div class="flex space-x-4">
            <button @click="$router.push('/patients')" class="btn-secondary">
              <i class="fas fa-arrow-left mr-2"></i>Kembali
            </button>
            <button @click="showAddNoteModal = true" class="btn-primary">
              <i class="fas fa-plus mr-2"></i>Tambah Catatan
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Patient Info Card -->
        <div class="bg-white shadow rounded-lg mb-6">
          <div class="px-4 py-5 sm:p-6">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
              <div>
                <h3 class="text-sm font-medium text-gray-500">Status Pathway</h3>
                <p class="mt-1 text-lg font-semibold text-gray-900">
                  <span :class="[
                    'px-2 py-1 inline-flex text-sm leading-5 font-semibold rounded-full',
                    patient.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                  ]">
                    {{ patient.status === 'active' ? 'Aktif' : 'Selesai' }}
                  </span>
                </p>
              </div>
              <div>
                <h3 class="text-sm font-medium text-gray-500">Tanggal Mulai</h3>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ patient.startDate }}</p>
              </div>
              <div>
                <h3 class="text-sm font-medium text-gray-500">Tahap Saat Ini</h3>
                <p class="mt-1 text-lg font-semibold text-gray-900">{{ patient.currentStage }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Pathway Timeline -->
        <div class="bg-white shadow rounded-lg mb-6">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Timeline Pathway</h3>
            <div class="flow-root">
              <ul role="list" class="-mb-8">
                <li v-for="(stage, index) in pathwayStages" :key="index">
                  <div class="relative pb-8">
                    <span v-if="index !== pathwayStages.length - 1" class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                    <div class="relative flex space-x-3">
                      <div>
                        <span :class="[
                          'h-8 w-8 rounded-full flex items-center justify-center ring-8 ring-white',
                          stage.completed ? 'bg-green-500' : 'bg-gray-400'
                        ]">
                          <i :class="[
                            'fas',
                            stage.icon,
                            'text-white'
                          ]"></i>
                        </span>
                      </div>
                      <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                        <div>
                          <p class="text-sm font-medium text-gray-900">
                            {{ stage.name }}
                            <span v-if="stage.completed" class="text-green-600 text-xs ml-2">
                              <i class="fas fa-check"></i> Selesai
                            </span>
                          </p>
                          <p class="text-sm text-gray-500">{{ stage.description }}</p>
                        </div>
                        <div class="text-right text-sm whitespace-nowrap text-gray-500">
                          <time :datetime="stage.date">{{ stage.date }}</time>
                        </div>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <!-- Medical Notes -->
        <div class="bg-white shadow rounded-lg">
          <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Catatan Medis</h3>
            <div class="space-y-4">
              <div v-for="note in medicalNotes" :key="note.id" class="border-l-4 border-blue-500 pl-4 py-2">
                <div class="flex justify-between items-start">
                  <div>
                    <p class="text-sm font-medium text-gray-900">{{ note.author }}</p>
                    <p class="text-sm text-gray-500">{{ note.date }}</p>
                  </div>
                  <span :class="[
                    'px-2 py-1 text-xs rounded-full',
                    noteTypeClasses[note.type]
                  ]">
                    {{ note.type }}
                  </span>
                </div>
                <p class="mt-2 text-sm text-gray-700">{{ note.content }}</p>
                <div v-if="note.attachments && note.attachments.length" class="mt-2">
                  <div class="flex space-x-2">
                    <a v-for="attachment in note.attachments" 
                       :key="attachment.id"
                       :href="attachment.url"
                       class="text-blue-600 hover:text-blue-800 text-sm">
                      <i class="fas fa-paperclip mr-1"></i>
                      {{ attachment.name }}
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Add Note Modal -->
    <div v-if="showAddNoteModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Catatan Medis</h3>
            <form @submit.prevent="handleAddNote">
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tipe Catatan</label>
                <select v-model="newNote.type" required
                  class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                  <option value="Pemeriksaan">Pemeriksaan</option>
                  <option value="Pengobatan">Pengobatan</option>
                  <option value="Evaluasi">Evaluasi</option>
                </select>
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Catatan</label>
                <textarea v-model="newNote.content" rows="4" required
                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md"></textarea>
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Lampiran</label>
                <input type="file" multiple
                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
              </div>
            </form>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="submit" class="btn-primary sm:ml-3">
              Simpan
            </button>
            <button @click="showAddNoteModal = false" class="btn-secondary">
              Batal
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'

const showAddNoteModal = ref(false)
const newNote = ref({
  type: 'Pemeriksaan',
  content: ''
})

// Mock data
const patient = ref({
  name: 'Budi Santoso',
  nik: '3271046501890002',
  status: 'active',
  startDate: '2024-04-01',
  currentStage: 'Pengobatan'
})

const pathwayStages = ref([
  {
    name: 'Skrining',
    description: 'Pemeriksaan awal dan identifikasi gejala',
    date: '2024-04-01',
    completed: true,
    icon: 'fa-clipboard-check'
  },
  {
    name: 'Diagnosis',
    description: 'Konfirmasi diagnosis melalui pemeriksaan laboratorium',
    date: '2024-04-03',
    completed: true,
    icon: 'fa-microscope'
  },
  {
    name: 'Pengobatan',
    description: 'Pemberian obat anti-tuberkulosis',
    date: '2024-04-05',
    completed: false,
    icon: 'fa-pills'
  },
  {
    name: 'Evaluasi',
    description: 'Pemantauan kemajuan pengobatan',
    date: null,
    completed: false,
    icon: 'fa-chart-line'
  }
])

const medicalNotes = ref([
  {
    id: 1,
    author: 'dr. Sarah',
    date: '2024-04-01',
    type: 'Pemeriksaan',
    content: 'Pasien menunjukkan gejala batuk >2 minggu, demam, dan penurunan berat badan.',
    attachments: [
      { id: 1, name: 'hasil-lab.pdf', url: '#' }
    ]
  },
  {
    id: 2,
    author: 'dr. Rudi',
    date: '2024-04-03',
    type: 'Pengobatan',
    content: 'Memulai pengobatan fase intensif dengan HRZE.',
    attachments: []
  }
])

const noteTypeClasses = {
  'Pemeriksaan': 'bg-blue-100 text-blue-800',
  'Pengobatan': 'bg-green-100 text-green-800',
  'Evaluasi': 'bg-yellow-100 text-yellow-800'
}

const handleAddNote = () => {
  // TODO: Implement actual note addition logic
  console.log('Adding new note:', newNote.value)
  showAddNoteModal.value = false
}
</script>
