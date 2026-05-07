// src/router.js
import { createRouter, createWebHistory } from 'vue-router';
import BlogFeed from './components/Blog.vue'; 
import CreatePost from './components/CreatePost.vue';

const routes = [
  {
    path: '/',
    name: 'Home',
    component: BlogFeed
  },
  {
    path: '/create',
    name: 'Create',
    component: CreatePost
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;