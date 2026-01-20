<script lang="ts" setup>
import { ref, onMounted } from 'vue'
import { getJobApplications, type JobApplication } from '../services/api'
import JobApplicationsTable from '@/components/JobApplicationsTable.vue'

const jobs = ref<JobApplication[]>([])

onMounted(async () => {
  jobs.value = await getJobApplications()
})
</script>

<template>
  <div>
    <h1>Bewerbungen</h1>
  </div>
  <JobApplicationsTable :job-applications="jobs" v-if="jobs.length > 0"></JobApplicationsTable>

  <div v-else>
    <p>keine bewerbungen gefunden</p>
  </div>
</template>
