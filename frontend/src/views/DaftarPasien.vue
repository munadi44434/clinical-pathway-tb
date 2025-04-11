<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
          <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-900">Daftar Pasien</h1>
            <div class="space-x-4">
              <router-link 
                to="/clinical-pathway" 
                class="btn-primary"
              >
                <i class="fas fa-file-medical mr-2"></i>Clinical Pathway
              </router-link>
              <button @click="showAddPatientModal = true" class="btn-primary">
                <i class="fas fa-plus mr-2"></i>Tambah Pasien
              </button>
            </div>
          </div>
      </div>
    </header>

    <!-- Main Content -->
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Search and Filter -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
          <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
            <div>
              <label class="block text-sm font-medium text-gray-700">Cari Pasien</label>
              <div class="mt-1 relative rounded-md shadow-sm">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                  <i class="fas fa-search text-gray-400"></i>
                </div>
                <input
                  type="text"
                  v-model="searchQuery"
                  class="focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                  placeholder="Cari berdasarkan nama atau NIK"
                />
              </div>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Status Pathway</label>
              <select
                v-model="filterStatus"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
              >
                <option value="">Semua Status</option>
                <option value="active">Aktif</option>
                <option value="completed">Selesai</option>
              </select>
            </div>
            <div>
              <label class="block text-sm font-medium text-gray-700">Tahap Pathway</label>
              <select
                v-model="filterStage"
                class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md"
              >
                <option value="">Semua Tahap</option>
                <option value="skrining">Skrining</option>
                <option value="diagnosis">Diagnosis</option>
                <option value="pengobatan">Pengobatan</option>
                <option value="evaluasi">Evaluasi</option>
              </select>
            </div>
          </div>
        </div>

        <!-- Patients Table -->
        <div class="bg-white shadow rounded-lg">
          <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                  <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                      <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Nama / NIK
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Status
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Tahap
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Tanggal Mulai
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                          Aksi
                        </th>
                      </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                      <tr v-for="patient in filteredPatients" :key="patient.id">
                        <td class="px-6 py-4 whitespace-nowrap">
                          <div class="text-sm font-medium text-gray-900">{{ patient.name }}</div>
                          <div class="text-sm text-gray-500">{{ patient.nik }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                          <span :class="[
                            'px-2 inline-flex text-xs leading-5 font-semibold rounded-full',
                            patient.status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'
                          ]">
                            {{ patient.status === 'active' ? 'Aktif' : 'Selesai' }}
                          </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          {{ patient.stage }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                          {{ patient.startDate }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                          <button
                            @click="viewPatientDetails(patient.id)"
                            class="text-blue-600 hover:text-blue-900 mr-4"
                          >
                            <i class="fas fa-eye"></i>
                          </button>
                          <button
                            @click="editPatient(patient.id)"
                            class="text-indigo-600 hover:text-indigo-900"
                          >
                            <i class="fas fa-edit"></i>
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <!-- Add Patient Modal -->
    <div v-if="showAddPatientModal" class="fixed z-10 inset-0 overflow-y-auto">
      <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 transition-opacity" aria-hidden="true">
          <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
        </div>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
          <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Tambah Pasien Baru</h3>
            <form @submit.prevent="handleAddPatient">
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                <input type="text" v-model="newPatient.name" required
                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">NIK</label>
                <input type="text" v-model="newPatient.nik" required
                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tanggal Lahir</label>
                <input type="date" v-model="newPatient.birthDate" required
                  class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" />
              </div>
              <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Jenis Kelamin</label>
                <select v-model="newPatient.gender" required
                  class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
            </form>
          </div>
          <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button type="submit" class="btn-primary sm:ml-3">
              Simpan
            </button>
            <button @click="showAddPatientModal = false" class="btn-secondary">
              Batal
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()
const searchQuery = ref('')
const filterStatus = ref('')
const filterStage = ref('')
const showAddPatientModal = ref(false)

const newPatient = ref({
  name: '',
  nik: '',
  birthDate: '',
  gender: 'L'
})

// Mock data
const patients = ref([
  {
    id: 1,
    name: 'Budi Santoso',
    nik: '3271046501890002',
    status: 'active',
    stage: 'Pengobatan',
    startDate: '2024-04-01'
  },
  {
    id: 2,
    name: 'Siti Rahayu',
    nik: '3271046501890003',
    status: 'active',
    stage: 'Diagnosis',
    startDate: '2024-04-03'
  },
  {
    id: 3,
    name: 'Ahmad Hidayat',
    nik: '3271046501890004',
    status: 'completed',
    stage: 'Selesai',
    startDate: '2024-03-15'
  }
])

const filteredPatients = computed(() => {
  return patients.value.filter(patient => {
    const matchesSearch = searchQuery.value === '' ||
      patient.name.toLowerCase().includes(searchQuery.value.toLowerCase()) ||
      patient.nik.includes(searchQuery.value)
    const matchesStatus = filterStatus.value === '' || patient.status === filterStatus.value
    const matchesStage = filterStage.value === '' || patient.stage.toLowerCase() === filterStage.value
    return matchesSearch && matchesStatus && matchesStage
  })
})

const handleAddPatient = () => {
  // TODO: Implement actual patient addition logic
  console.log('Adding new patient:', newPatient.value)
  showAddPatientModal.value = false
}

const viewPatientDetails = (patientId) => {
  router.push(`/patients/${patientId}`)
}

const editPatient = (patientId) => {
  // TODO: Implement patient editing logic
  console.log('Editing patient:', patientId)
}
</script>
