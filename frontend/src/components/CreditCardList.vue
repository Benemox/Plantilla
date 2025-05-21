<template>
  <div>
    <h2>Available Credit Cards</h2>
    <div class="controls">
      <button @click="sortBy('price')">Sort by Price</button>
      <button @click="sortBy('name')">Sort by Name</button>
    </div>
    <ul>
      <li v-for="card in sortedCards" :key="card.id">
        <img :src="card.logo" :alt="card.name" width="100" />
        <h3>{{ card.name }}</h3>
        <p>Bank: {{ card.bank }}</p>
        <p>Annual Fee: {{ card.annualFee }}€</p>
        <p>Interest Rate: {{ card.interestRate }}%</p>
        <p>Price: {{ card.price }}€</p>
        <div class="tags">
          <span v-if="card.benefits">✓ Benefits</span>
          <span v-if="card.insurances">✓ Insurances</span>
          <span v-if="card.services">✓ Services</span>
        </div>
      </li>
    </ul>
  </div>
</template>

<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import type { CreditCard } from '../types/CreditCard';

const cards = ref<CreditCard[]>([]);
const sortByField = ref<'price' | 'name'>('name');
const sortDirection = ref<'asc' | 'desc'>('asc');

const fetchCreditCards = async () => {
  try {
    const url = new URL('http://localhost:8001/api/v1/cards');
    url.searchParams.append('sortBy', sortByField.value);
    url.searchParams.append('order', sortDirection.value);

    const response = await fetch(url.toString());
    if (!response.ok) throw new Error('Failed to fetch credit cards');
    cards.value = await response.json();
  } catch (error) {
    console.error('Error fetching credit cards:', error);
  }
};

const sortBy = (field: 'price' | 'name') => {
  if (sortByField.value === field) {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
  } else {
    sortByField.value = field;
    sortDirection.value = 'asc';
  }
  fetchCreditCards();
};

const sortedCards = computed(() => {
  return cards.value;
});

onMounted(fetchCreditCards);
</script>

<style scoped>
.controls {
  margin-bottom: 10px;
}
button {
  margin-right: 5px;
  padding: 5px 10px;
  cursor: pointer;
}
.tags {
  margin-top: 5px;
}
.tags span {
  display: inline-block;
  margin-right: 5px;
  background: #ddd;
  padding: 3px 8px;
  border-radius: 5px;
}
</style>
