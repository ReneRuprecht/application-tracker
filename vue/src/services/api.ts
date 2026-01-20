export interface JobApplication {
  id: string
  company: string
  position: string
  appliedAt: string
}

export async function getJobApplications(): Promise<JobApplication[]> {
  const url = import.meta.env.VITE_API_ENDPOINT
  const res = await fetch(`${url}/v1/job-applications`)

  if (!res.ok) {
    throw new Error(`Failed to applications: ${res.status}`)
  }

  const data: JobApplication[] = await res.json()
  return data || []
}
