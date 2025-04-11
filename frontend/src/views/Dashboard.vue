<template>
  <div class="min-h-screen bg-gray-100">
    <!-- Header -->
    <header class="bg-white shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
          <h1 class="text-3xl font-bold text-gray-900">Dashboard</h1>
          <div class="flex items-center space-x-4">
            <router-link 
              to="/clinical-pathway" 
              class="btn-primary"
            >
              <i class="fas fa-file-medical mr-2"></i>Clinical Pathway
            </router-link>
            <button @click="logout" class="btn-secondary">
              <i class="fas fa-sign-out-alt mr-2"></i>Keluar
            </button>
          </div>
        </div>
      </div>
    </header>

    <!-- Main Content -->
    <main>
      <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
          <!-- Total Pasien -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <i class="fas fa-users text-2xl text-blue-500"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                      Total Pasien
                    </dt>
                    <dd class="text-lg font-semibold text-gray-900">
                      {{ stats.totalPatients }}
                    </dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Pathway Aktif -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <i class="fas fa-clipboard-list text-2xl text-green-500"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                      Pathway Aktif
                    </dt>
                    <dd class="text-lg font-semibold text-gray-900">
                      {{ stats.activePathways }}
                    </dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Selesai Bulan Ini -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <i class="fas fa-check-circle text-2xl text-indigo-500"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                      Selesai Bulan Ini
                    </dt>
                    <dd class="text-lg font-semibold text-gray-900">
                      {{ stats.completedThisMonth }}
                    </dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>

          <!-- Evaluasi Pending -->
          <div class="bg-white overflow-hidden shadow rounded-lg">
            <div class="p-5">
              <div class="flex items-center">
                <div class="flex-shrink-0">
                  <i class="fas fa-clock text-2xl text-yellow-500"></i>
                </div>
                <div class="ml-5 w-0 flex-1">
                  <dl>
                    <dt class="text-sm font-medium text-gray-500 truncate">
                      Evaluasi Pending
                    </dt>
                    <dd class="text-lg font-semibold text-gray-900">
                      {{ stats.pendingEvaluations }}
                    </dd>
                  </dl>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Patients Table -->
        <div class="mt-8">
          <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 border-b border-gray-200 sm:px-6">
              <h3 class="text-lg leading-6 font-medium text-gray-900">
                Pasien Terbaru
              </h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
              <div class="flex flex-col">
                <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                  <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                      <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                          <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                              Nama
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
                          </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                          <tr v-for="patient in recentPatients" :key="patient.id">
                            <td class="px-6 py-4 whitespace-nowrap">
                              <div class="text-sm font-medium text-gray-900">
                                {{ patient.name }}
                              </div>
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
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'

const router = useRouter()

// Mock data
const stats = ref({
  totalPatients: 156,
  activePathways: 42,
  completedThisMonth: 15,
  pendingEvaluations: 8
})

const recentPatients = ref([
  {
    id: 1,
    name: 'Budi Santoso',
    status: 'active',
    stage: 'Pengobatan',
    startDate: '2024-04-01'
  },
  {
    id: 2,
    name: 'Siti Rahayu',
    status: 'active',
    stage: 'Diagnosis',
    startDate: '2024-04-03'
  },
  {
    id: 3,
    name: 'Ahmad Hidayat',
    status: 'completed',
    stage: 'Selesai',
    startDate: '2024-03-15'
  }
])

const logout = () => {
  // Clear authentication state
  localStorage.removeItem('authToken')
  localStorage.removeItem('userData')
  
  // Redirect to login page
  router.push('/login')
}
</script>
