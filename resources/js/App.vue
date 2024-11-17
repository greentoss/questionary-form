<template>
    <div :class="settings.backgroundColor" class="min-h-screen m-auto px-0 sm:px-4 md:px-8 py-8 max-w-[1240px]">
      <h1 class="text-4xl font-bold text-center mb-8">Dynamic Form Application</h1>
      <QuestionaryForm />
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent, reactive, onMounted } from 'vue';
  import axios from 'axios';
  import QuestionaryForm from './components/QuestionaryForm.vue';
  
  interface Settings {
    backgroundColor: string;
  }
  
  export default defineComponent({
    name: 'App',
    components: { QuestionaryForm },А
    setup() {
      const settings = reactive<Settings>({
        backgroundColor: 'bg-white',
      });
  
      const fetchSettings = async () => {
        try {
          const { data } = await axios.get('/api/form');
          Object.assign(settings, data.settings);
        } catch (error) {
          console.error('Failed to fetch settings:', error);
        }
      };
  
      onMounted(fetchSettings);
  
      return { settings };
    },
  });
  </script>
  
  <style>
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
  }
  </style>
  