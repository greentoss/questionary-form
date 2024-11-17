<template>
    <div class="shadow-md rounded p-6 transition-opacity duration-500" :class="{ 'opacity-100': isLoadedFields, 'opacity-0': !isLoadedFields }">
      <h2 class="text-2xl font-semibold mb-4">Your contact data</h2>
      <div class="mt-4 mb-6">
        <ProgressBar :progress="progress || 0" :status="progressStatus" />
      </div>
      <form @submit.prevent="submitForm" class="space-y-4">
        <div v-for="field in fields" :key="field.name" class="mb-4">
          <label :for="field.name" class="block font-medium text-gray-700">
            {{ field.label }}
            <span v-if="field.required" class="text-red-500">*</span>
          </label>
          <input
            v-if="field.type === 'text' || field.type === 'email'"
            :type="field.type"
            :id="field.name"
            v-model="formData[field.name]"
            @input="handleInput"
            :placeholder="getPlaceholder(field)"
            class="block w-full p-2 border border-gray-300 rounded"
          />
          <select
            v-if="field.type === 'select'"
            :id="field.name"
            v-model="formData[field.name]"
            @change="handleInput"
            class="block w-full p-2 border border-gray-300 rounded"
          >
            <option value="" disabled>{{ getPlaceholder(field) }}</option>
            <option v-for="option in field.options" :key="option" :value="option">
              {{ option }}
            </option>
          </select>
          <input
            v-if="field.type === 'date'"
            type="date"
            :id="field.name"
            v-model="formData[field.name]"
            @input="handleInput"
            :placeholder="getPlaceholder(field)"
            class="block w-full p-2 border border-gray-300 rounded"
          />
          <!-- Validation Error Message -->
          <p v-if="errors[field.name]" class="text-red-500 text-sm mt-1">
            {{ errors[field.name] }}
          </p>
        </div>
        <div class="flex justify-end">
          <button
            type="submit"
            class="w-full sm:w-auto bg-blue-500 text-white px-4 sm:px-8 py-2 rounded-lg"
          >
            Надіслати
          </button>
        </div>
      </form>
    </div>
  </template>
  
<script lang="ts">
    import { defineComponent, reactive, ref, computed, PropType } from 'vue';
    import axios from 'axios';
    import ProgressBar from './molecules/ProgressBar.vue';

    interface Field {
    name: string;
    type: string;
    label: string;
    required: boolean;
    options?: string[];
    }

    export default defineComponent({
    name: 'QuestionaryForm',
    components: { ProgressBar },
    props: {
        fields: {
        type: Array as PropType<Field[]>,
        required: true,
        },
        isLoadedFields: {
        type: Boolean,
        required: true,
        },
    },
    setup(props) {
        const formData = reactive<Record<string, string | null>>({});
        const errors = reactive<Record<string, string | null>>({});
        const progressStatus = ref<'default' | 'success' | 'error'>('default'); // Use `ref`

        // Initialize formData and errors
        props.fields.forEach((field) => {
        formData[field.name] = '';
        errors[field.name] = null;
        });

        // Compute progress based on filled fields
        const progress = computed(() => {
            const totalFields = props.fields.length;
            if (totalFields === 0) return 0; // Prevent division by zero
            const filledFields = Object.values(formData).filter((value) => value && value.trim() !== '').length;
            return Math.round((filledFields / totalFields) * 100);
        });

        const handleInput = () => {
        progressStatus.value = 'default'; // Reset status to default while filling
        };

        const clearError = (fieldName: string) => {
        errors[fieldName] = null;
        };

        const submitForm = async () => {
        try {
            const response = await axios.post('/api/form/submit', formData);
            alert(response.data.message);

            Object.keys(errors).forEach((key) => {
            errors[key] = null;
            });

            progressStatus.value = 'success'; // Green bar on successful submission
        } catch (error: any) {
            if (error.response && error.response.data.errors) {
            const serverErrors = error.response.data.errors;

            for (const key in serverErrors) {
                if (serverErrors[key]?.length) {
                errors[key] = serverErrors[key][0];
                }
            }

            progressStatus.value = 'error'; // Red bar on validation failure
            } else {
            console.error('Form submission failed:', error);
            alert('Form submission failed. Please try again.');
            progressStatus.value = 'error';
            }
        } finally {
            scrollToTop();
        }
        };

        const getPlaceholder = (field: Field): string => {
        if (field.name === 'phoneNumber') {
            return '+380xxxxxxxxx';
        } else if (field.type === 'email') {
            return 'example@domain.com';
        } else if (field.type === 'text') {
            return `${field.label.toLowerCase()}`;
        } else if (field.type === 'date') {
            return 'YYYY-MM-DD';
        } else if (field.type === 'select') {
            return `${field.label.toLowerCase()}`;
        }
        return '';
        };

        const scrollToTop = () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
        };

        return {
        formData,
        errors,
        progress,
        progressStatus, // Pass ref to template
        submitForm,
        getPlaceholder,
        clearError,
        handleInput,
        };
    },
    });

</script>
  