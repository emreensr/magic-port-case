<!-- resources/js/components/Dropdown.vue -->
<template>
    <div class="relative">
      <button @click="toggleDropdown" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
        <div>{{ userName }}</div>
        <div class="ms-1">
          <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </div>
      </button>

      <div v-show="isOpen" class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 shadow-lg">
        <a href="/profile" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Profile</a>
        <form @submit.prevent="logout">
          <button type="submit" class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Log Out</button>
        </form>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';

  const props = defineProps({
    userName: String
  });

  const isOpen = ref(false);

  const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
  };

  const logout = () => {
    document.querySelector('form').submit();
  };
  </script>

  <style scoped>
  /* Dropdown styles */
  </style>
