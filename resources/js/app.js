import { createApp } from 'vue';
import ProjectComponent from './components/ProjectComponent.vue';
import ProjectDetail from './components/ProjectDetail.vue';

const app = createApp({});
app.component('project-component', ProjectComponent);
app.component('project-detail', ProjectDetail);
app.mount('#app');

