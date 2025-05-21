<template>
  <header>
    <nav>
      <RouterLink to="/">Home</RouterLink>
      <RouterLink to="/cards">Credit Cards</RouterLink>
    </nav>
  </header>
  <main>
    <RouterView />
  </main>
</template>

<script setup lang="ts">
import { RouterLink, RouterView } from 'vue-router';
</script>

<style scoped>
header {
  padding: 10px;
  background: #333;
  color: white;
  text-align: center;
}

nav {
  display: flex;
  justify-content: center;
  gap: 15px;
}

nav a {
  color: white;
  text-decoration: none;
  font-size: 18px;
}
nav a:hover {
  text-decoration: underline;
}
main {
  padding: 20px;
}
</style>
