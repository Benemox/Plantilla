import { createRouter, createWebHistory } from 'vue-router';
import HomeView from "@/views/HomeView.vue";
import CreditCards from "@/views/CreditCards.vue";

const routes = [
  { path: '/', component: HomeView },
  { path: '/cards', component: CreditCards }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
