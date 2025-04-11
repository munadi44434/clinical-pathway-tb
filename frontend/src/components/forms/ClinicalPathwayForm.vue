<template>
  <div class="w-full p-4 bg-white rounded-lg shadow-md">
    <div class="bg-blue-100 p-4 rounded-lg mb-6">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center space-x-4">
          <img :src="hospitalLogo" alt="Hospital Logo" class="h-16">
          <div>
            <h1 class="text-xl font-bold">Clinical Pathway Tuberkulosis</h1>
            <div class="flex flex-col md:flex-row md:space-x-4 gap-2 text-sm">
              <div>No. CP: <span class="font-semibold">{{ formData.cp_number }}</span></div>
              <div>Tanggal Berlaku: <input type="date" v-model="formData.effective_date" class="border rounded px-2"></div>
              <div>
                <label class="mr-2">Tipe TB:</label>
                <select v-model="formData.tb_type" class="border rounded px-2">
                  <option value="pulmonary">Pulmonary</option>
                  <option value="extrapulmonary">Extra-pulmonary</option>
                  <option value="mdr">MDR-TB</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="flex space-x-2">
          <router-link to="/dashboard" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
          </router-link>
          <router-link to="/patients" class="btn-primary">
            <i class="fas fa-list mr-2"></i>Daftar Pasien
          </router-link>
        </div>
      </div>
    </div>

    <div class="bg-yellow-50 p-4 rounded-lg mb-6">
      <h2 class="font-bold mb-2">DATA PASIEN TB</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium">Nama Pasien</label>
          <input v-model="formData.patient_name" class="w-full border rounded px-2 py-1">
        </div>
        <div>
          <label class="block text-sm font-medium">Tanggal Lahir</label>
          <input type="date" v-model="formData.birth_date" class="w-full border rounded px-2 py-1">
        </div>
        <div>
          <label class="block text-sm font-medium">Nomor RM</label>
          <input v-model="formData.medical_record_number" class="w-full border rounded px-2 py-1">
        </div>
        <div>
          <label class="block text-sm font-medium">Dokter Penanggungjawab</label>
          <input v-model="formData.doctor_in_charge" class="w-full border rounded px-2 py-1">
        </div>
        <div>
          <label class="block text-sm font-medium">Tanggal Diagnosis</label>
          <input type="date" v-model="formData.diagnosis_date" class="w-full border rounded px-2 py-1">
        </div>
        <div>
          <label class="block text-sm font-medium">Hasil Tes Dahak</label>
          <select v-model="formData.sputum_test" class="w-full border rounded px-2 py-1">
            <option value="positive">Positif</option>
            <option value="negative">Negatif</option>
            <option value="pending">Menunggu Hasil</option>
          </select>
        </div>
        <div class="md:col-span-2 lg:col-span-3">
          <label class="block text-sm font-medium">Catatan Khusus</label>
          <textarea v-model="formData.special_notes" class="w-full border rounded px-2 py-1"></textarea>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full clinical-pathway-table">
        <thead class="bg-blue-100">
          <tr>
            <th class="p-2 text-left">Komponen</th>
            <th class="p-2 text-left">Konten</th>
            <th class="p-2 text-center">Minggu 1</th>
            <th class="p-2 text-center">Minggu 2</th>
            <th class="p-2 text-center">Minggu 3</th>
            <th class="p-2 text-center">Minggu 4</th>
            <th class="p-2 text-left">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(service, index) in formData.clinical_services" :key="index" 
              :class="{'bg-pink-50': service.component === 'Diagnosis'}">
            <td class="p-2 border">{{ service.component }}</td>
            <td class="p-2 border">{{ service.content }}</td>
            <td class="p-2 border text-center">
              <input type="checkbox" v-model="service.week1" v-if="service.week1 !== undefined">
            </td>
            <td class="p-2 border text-center">
              <input type="checkbox" v-model="service.week2" v-if="service.week2 !== undefined">
            </td>
            <td class="p-2 border text-center">
              <input type="checkbox" v-model="service.week3" v-if="service.week3 !== undefined">
            </td>
            <td class="p-2 border text-center">
              <input type="checkbox" v-model="service.week4" v-if="service.week4 !== undefined">
            </td>
            <td class="p-2 border">{{ service.notes }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
      <button @click="saveForm" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
      <button @click="exportToExcel" class="bg-green-500 text-white px-4 py-2 rounded">Export Excel</button>
    </div>
      } catch (error) {
        this.showError = true;
        this.message = 'Gagal mengekspor data: ' + (error.response?.data?.message || error.message);
      } finally {
        this.isLoading = false;
      }
    }
  },
  created() {
    this.formData.cp_number = `CP-TB-${Date.now()}`;
  }
}
</script>

<template>
  <div class="w-full p-4 bg-white rounded-lg shadow-md">
    <!-- Notification Alerts -->
    <div v-if="showSuccess" class="mb-4 p-4 bg-green-100 text-green-800 rounded">
      {{ message }}
      <button @click="showSuccess = false" class="float-right">×</button>
    </div>
    <div v-if="showError" class="mb-4 p-4 bg-red-100 text-red-800 rounded">
      {{ message }}
      <button @click="showError = false" class="float-right">×</button>
    </div>
    
    <div class="bg-blue-100 p-4 rounded-lg mb-6">
      <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div class="flex items-center space-x-4">
          <img :src="hospitalLogo" alt="Hospital Logo" class="h-16">
          <div>
            <h1 class="text-xl font-bold">Clinical Pathway Tuberkulosis</h1>
            <div class="flex flex-col md:flex-row md:space-x-4 gap-2 text-sm">
              <div>No. CP: <span class="font-semibold">{{ formData.cp_number }}</span></div>
              <div>Tanggal Berlaku: <input type="date" v-model="formData.effective_date" class="border rounded px-2"></div>
              <div>
                <label class="mr-2">Tipe TB:</label>
                <select v-model="formData.tb_type" class="border rounded px-2">
                  <option value="pulmonary">Pulmonary</option>
                  <option value="extrapulmonary">Extra-pulmonary</option>
                  <option value="mdr">MDR-TB</option>
                </select>
              </div>
            </div>
          </div>
        </div>
        <div class="flex space-x-2">
          <router-link to="/dashboard" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i>Kembali
          </router-link>
          <router-link to="/patients" class="btn-primary">
            <i class="fas fa-list mr-2"></i>Daftar Pasien
          </router-link>
        </div>
      </div>
    </div>

    <div class="bg-yellow-50 p-4 rounded-lg mb-6">
      <h2 class="font-bold mb-2">DATA PASIEN TB</h2>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        <div>
          <label class="block text-sm font-medium">Nama Pasien <span class="text-red-500">*</span></label>
          <input v-model="formData.patient_name" class="w-full border rounded px-2 py-1" required>
        </div>
        <div>
          <label class="block text-sm font-medium">Tanggal Lahir</label>
          <input type="date" v-model="formData.birth_date" class="w-full border rounded px-2 py-1">
        </div>
        <div>
          <label class="block text-sm font-medium">Nomor RM <span class="text-red-500">*</span></label>
          <input v-model="formData.medical_record_number" class="w-full border rounded px-2 py-1" required>
        </div>
        <div>
          <label class="block text-sm font-medium">Dokter Penanggungjawab</label>
          <input v-model="formData.doctor_in_charge" class="w-full border rounded px-2 py-1">
        </div>
        <div>
          <label class="block text-sm font-medium">Tanggal Diagnosis</label>
          <input type="date" v-model="formData.diagnosis_date" class="w-full border rounded px-2 py-1">
        </div>
        <div>
          <label class="block text-sm font-medium">Hasil Tes Dahak</label>
          <select v-model="formData.sputum_test" class="w-full border rounded px-2 py-1">
            <option value="positive">Positif</option>
            <option value="negative">Negatif</option>
            <option value="pending">Menunggu Hasil</option>
          </select>
        </div>
        <div class="md:col-span-2 lg:col-span-3">
          <label class="block text-sm font-medium">Catatan Khusus</label>
          <textarea v-model="formData.special_notes" class="w-full border rounded px-2 py-1"></textarea>
        </div>
      </div>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full clinical-pathway-table">
        <thead class="bg-blue-100">
          <tr>
            <th class="p-2 text-left">Komponen</th>
            <th class="p-2 text-left">Konten</th>
            <th class="p-2 text-center">Minggu 1</th>
            <th class="p-2 text-center">Minggu 2</th>
            <th class="p-2 text-center">Minggu 3</th>
            <th class="p-2 text-center">Minggu 4</th>
            <th class="p-2 text-left">Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(service, index) in formData.clinical_services" :key="index" 
              :class="{'bg-pink-50': service.component === 'Diagnosis'}">
            <td class="p-2 border">{{ service.component }}</td>
            <td class="p-2 border">{{ service.content }}</td>
            <td class="p-2 border text-center">
              <input type="checkbox" v-model="service.week1" v-if="service.week1 !== undefined">
            </td>
            <td class="p-2 border text-center">
              <input type="checkbox" v-model="service.week2" v-if="service.week2 !== undefined">
            </td>
            <td class="p-2 border text-center">
              <input type="checkbox" v-model="service.week3" v-if="service.week3 !== undefined">
            </td>
            <td class="p-2 border text-center">
              <input type="checkbox" v-model="service.week4" v-if="service.week4 !== undefined">
            </td>
            <td class="p-2 border">{{ service.notes }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="mt-6 flex justify-end space-x-4">
      <button 
        @click="saveForm" 
        class="bg-blue-500 text-white px-4 py-2 rounded"
        :disabled="isLoading"
      >
        <span v-if="isLoading">Menyimpan...</span>
        <span v-else>Simpan</span>
      </button>
      <button 
        @click="exportToExcel" 
        class="bg-green-500 text-white px-4 py-2 rounded"
        :disabled="isLoading"
      >
        <span v-if="isLoading">Mengekspor...</span>
        <span v-else>Export Excel</span>
      </button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import hospitalLogo from '../assets/hospital-logo.png';

export default {
  data() {
    return {
      isLoading: false,
      showSuccess: false,
      showError: false,
      message: '',
      formData: {
        cp_number: '',
        effective_date: new Date().toISOString().split('T')[0],
        patient_name: '',
        medical_record_number: '',
        birth_date: '',
        doctor_in_charge: '',
        special_notes: '',
        clinical_services: [
          { 
            component: 'Diagnosis', 
            content: 'Pemeriksaan dahak mikroskopis', 
            week1: true, week2: false, week3: false, week4: false,
            notes: '3 spesimen dahak' 
          },
          { 
            component: 'Diagnosis', 
            content: 'Uji sensitivitas obat', 
            week1: false, week2: true, week3: false, week4: false,
            notes: 'Untuk kasus MDR' 
          },
          { 
            component: 'Pengobatan', 
            content: 'Pemberian OAT fase intensif', 
            week1: true, week2: true, week3: true, week4: true,
            notes: '2HRZE' 
          },
          { 
            component: 'Pemantauan', 
            content: 'Evaluasi efek samping obat', 
            week1: true, week2: true, week3: true, week4: true,
            notes: 'LFT bulanan' 
          },
          { 
            component: 'Outcome', 
            content: 'Evaluasi pengobatan', 
            week1: false, week2: false, week3: false, week4: true,
            notes: 'Klinis dan bakteriologis' 
          }
        ],
        patient_criteria: 'Pasien TB baru tanpa komplikasi'
      },
      hospitalLogo: hospitalLogo
    }
  },
  methods: {
    async saveForm() {
      if (!this.validateForm()) return;
      
      this.isLoading = true;
      try {
        const response = await axios.post('/api/clinical-pathway', this.formData);
        this.showSuccess = true;
        this.message = 'Data berhasil disimpan!';
        this.resetForm();
      } catch (error) {
        this.showError = true;
        this.message = 'Gagal menyimpan data: ' + (error.response?.data?.message || error.message);
      } finally {
        this.isLoading = false;
      }
    },
    validateForm() {
      if (!this.formData.patient_name) {
        this.showError = true;
        this.message = 'Nama pasien harus diisi';
        return false;
      }
      if (!this.formData.medical_record_number) {
        this.showError = true;
        this.message = 'Nomor RM harus diisi';
        return false;
      }
      return true;
    },
    resetForm() {
      this.formData = {
        cp_number: `CP-TB-${Date.now()}`,
        effective_date: new Date().toISOString().split('T')[0],
        patient_name: '',
        medical_record_number: '',
        birth_date: '',
        doctor_in_charge: '',
        special_notes: '',
        clinical_services: [...this.formData.clinical_services]
      };
    },
    async exportToExcel() {
      this.isLoading = true;
      try {
        const response = await axios.post('/api/clinical-pathway/export', this.formData, {
          responseType: 'blob'
        });
        const url = window.URL.createObjectURL(new Blob([response.data]));
        const link = document.createElement('a');
        link.href = url;
        const filename = `clinical_pathway_${this.formData.patient_name || 'tb'}.xlsx`;
        link.setAttribute('download', filename);
        document.body.appendChild(link);
        link.click();
      } catch (error) {
        console.error('Error exporting data:', error);
      }
    }
  }
}
</script>

<style scoped>
table {
  border-collapse: collapse;
  width: 100%;
}
th, td {
  border: 1px solid #e2e8f0;
  padding: 8px;
}
.bg-blue-100 {
  background-color: #dbeafe;
}
.bg-yellow-50 {
  background-color: #fefce8;
}
.bg-pink-50 {
  background-color: #fdf2f8;
}
</style>
