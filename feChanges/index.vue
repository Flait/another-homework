<script setup>
import { onMounted, ref } from 'vue';

const projects = ref([]);
const meta = ref({
  current_page: 1,
  last_page: 1,
});
const perPage = ref(2);
const minPrice = ref(null);
const maxPrice = ref(null);

const loadProjects = async (page = 1) => {
  try {
    const query = new URLSearchParams({
      page: page,
      per_page: perPage.value,
      ...(minPrice.value !== null && { min_price: minPrice.value }),
      ...(maxPrice.value !== null && { max_price: maxPrice.value }),
    }).toString();

    const response = await fetch(`http://localhost:8000/api/v1/products?${query}`);

    if (!response.ok) {
      throw new Error('Failed to fetch projects');
    }
    const result = await response.json();
    projects.value = Object.values(result.data);
    meta.value = result.meta;
  } catch (error) {
    console.error('Error loading projects:', error);
  }
};

onMounted(() => {
  loadProjects();
});

</script>



<template>
  <h1>Projekty</h1>

  <div class="filters">
    <input type="number" v-model.number="minPrice" placeholder="Min cena" />
    <input type="number" v-model.number="maxPrice" placeholder="Max cena" />
    <button @click="loadProjects(1)">Použít filtry</button>
  </div>

  <div class="project-list">
    <ProjectItem v-for="project in projects" :key="project.id" :project="project" />
  </div>

  <div class="pagination">
    <button @click="loadProjects(meta.current_page - 1)" :disabled="meta.current_page <= 1">Předchozí</button>
    <span>Stránka {{ meta.current_page }} / {{ meta.last_page }}</span>
    <button @click="loadProjects(meta.current_page + 1)" :disabled="meta.current_page >= meta.last_page">Další</button>
  </div>
</template>



<style lang="scss">
.filters {
  margin-bottom: 20px;
  display: flex;
  gap: 10px;
}
.project-list {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.pagination {
  margin-top: 20px;
  display: flex;
  gap: 10px;
  align-items: center;
}
</style>
