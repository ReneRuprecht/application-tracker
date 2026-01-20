<script lang="ts" setup>
import type { JobApplication } from '@/services/api'

defineProps<{ jobApplications: JobApplication[] }>()
</script>
<template>
  <table>
    <tr>
      <th>Unternehmen</th>
      <th>Position</th>
      <th>Datum</th>
    </tr>
    <tr v-for="job in jobApplications" :key="job.id">
      <td>{{ job.company }}</td>
      <td>{{ job.position }}</td>
      <td>{{ job.appliedAt }}</td>
    </tr>
  </table>
</template>
