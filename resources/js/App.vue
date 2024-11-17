<template>
    <div class="bg-white min-h-screen m-auto px-0 sm:px-4 md:px-8 py-8 max-w-[1240px]">
      <h1 class="text-4xl font-bold text-center mb-8">Dynamic Form Application</h1>
      <QuestionaryForm
        :fields="fields"
        :isLoadedFields="isLoadedFields"
      />
    </div>
  </template>
  
  <script lang="ts">
  import { defineComponent, reactive, ref, onMounted } from 'vue';
  import axios from 'axios';
  import QuestionaryForm from './components/QuestionaryForm.vue';
  
  interface Field {
    name: string;
    type: string;
    label: string;
    required: boolean;
    options?: string[];
  }
  
  export default defineComponent({
    name: 'App',
    components: { QuestionaryForm },
    setup() {
      const fields = reactive<Field[]>([]);
      const isLoadedFields = ref(false);
  
      const fetchFields = async () => {
        try {
          const { data } = await axios.get('/api/form');
  
          if (data.fields && Array.isArray(data.fields)) {
            fields.push(...data.fields);
            isLoadedFields.value = true;
          } else {
            console.error('Invalid fields response:', data);
          }
        } catch (error) {
          console.error('Failed to fetch form fields:', error);
          alert('Error fetching form fields. Please try again later.');
        }
      };
  
      onMounted(fetchFields);
  
      return { fields, isLoadedFields };
    },
  });
  </script>
  
  <style>
  body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    overflow-y: scroll;
  }
  </style>
  