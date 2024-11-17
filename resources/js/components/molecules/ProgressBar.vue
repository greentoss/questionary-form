<template>
  <div class="w-full h-4 bg-gray-200 rounded overflow-hidden">
    <div
      class="h-full transition-all duration-500"
      :class="progressColor"
      :style="{ width: `${progress}%` }"
    ></div>
  </div>
</template>

<script lang="ts">
  import { defineComponent, PropType } from 'vue';

  export default defineComponent({
    name: 'ProgressBar',
    props: {
      progress: {
        type: Number,
        required: true,
        validator: (value: number) => value >= 0 && value <= 100,
      },
      status: {
        type: String as PropType<'default' | 'success' | 'error'>,
        default: 'default',
      },
    },
    computed: {
      progressColor(): string {
        switch (this.status) {
          case 'success':
            return 'bg-green-500'; // Green when successful
          case 'error':
            return 'bg-red-500'; // Red when an error occurs
          default:
            return 'bg-blue-500'; // Blue during normal progress
        }
      },
    },
  });
</script>