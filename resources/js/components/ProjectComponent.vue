<template>
    <div
        v-if="isModalOpen"
        class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-10 p-5"
    >
        <!-- Modal Container -->
        <div
            class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 transform transition-transform duration-300 ease-in-out scale-100"
        >
            <!-- Modal Header -->
            <div class="flex justify-between items-center border-b pb-3 mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Add New Project
                </h2>
                <button
                    @click="closeModal"
                    class="text-gray-500 hover:text-gray-700 transition-colors duration-200"
                >
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-6 w-6"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M6 18L18 6M6 6l12 12"
                        />
                    </svg>
                </button>
            </div>
            <!-- Modal Body -->
            <div>
                <form @submit.prevent="saveProject">
                    <div class="mb-4">
                        <label
                            for="name"
                            class="block text-sm font-medium text-gray-700"
                            >Project Name</label
                        >
                        <input
                            type="text"
                            id="name"
                            v-model="params.name"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            placeholder="Enter project name"
                        />
                    </div>
                    <div class="mb-6">
                        <label
                            for="description"
                            class="block text-sm font-medium text-gray-700"
                            >Project Description</label
                        >
                        <textarea
                            id="description"
                            v-model="params.description"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            placeholder="Enter project description"
                        ></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button
                            type="button"
                            @click="closeModal"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg mr-3 hover:bg-gray-400 transition-colors duration-200"
                        >
                            Cancel
                        </button>
                        <button
                            type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200"
                        >
                            Save
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="flex-1 bg-gray-100 p-6 max-w-6xl mx-auto">
        <header
            class="flex flex-col md:flex-row justify-between items-center mb-6"
        >
            <h2 class="text-3xl font-semibold mb-4 md:mb-0">Projects</h2>
            <div class="flex space-x-4">
                <button
                    @click="openModal"
                    class="bg-blue-500 text-white py-2 px-6 rounded-full shadow-md hover:bg-blue-600 hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2"
                >
                    Add Project
                </button>
                <input
                    type="text"
                    v-model="searchQuery"
                    @keyup="searchProjects"
                    placeholder="Search Projects..."
                    class="p-2 border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                />
            </div>
        </header>

        <!-- Project List -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <div
                v-for="project in filteredProjects"
                :key="project.id"
                class="bg-white p-4 rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out transform hover:-translate-y-1 relative"
            >
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-3">
                        <h3 class="text-2xl font-semibold text-gray-800">
                            {{ project.name }}
                        </h3>
                        <p>({{ project.tasks.length }} Tasks)</p>
                    </div>
                    <button
                        @click="deleteProject(project.id)"
                        class="text-red-500 hover:text-red-700 transition-colors duration-200"
                        title="Delete Project"
                    >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="h-6 w-6"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
                <p class="text-gray-600 leading-relaxed mt-5">
                    {{ project.description }}
                </p>
                <div class="mt-6 flex items-center justify-between">
                    <button
                        @click="viewDetails(project.id)"
                        class="bg-blue-500 text-white py-2 px-4 rounded-full text-sm font-medium hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300"
                    >
                        View Details
                    </button>
                    <div class="text-gray-500 text-sm">
                        Last updated:
                        <span class="font-semibold">{{
                            project.updated_at
                        }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

const viewDetails = (projectId) => {
    window.location.href = "/project/" + projectId;
};

const projects = ref([]);
const isModalOpen = ref(false);
const searchQuery = ref("");
const filteredProjects = ref([]);

const params = ref({
    name: "",
    description: "",
});

const openModal = () => {
    isModalOpen.value = true;
};

const closeModal = () => {
    isModalOpen.value = false;
};

const fetchProjects = async () => {
    try {
        const response = await axios.get("/api/project");
        projects.value = response.data.data;
        searchProjects();
    } catch (error) {
        console.error("Failed to fetch projects:", error);
    }
};

const saveProject = () => {
    if (!params.value.name) {
        showMessage("Name is required.", "error");
        return;
    }
    if (!params.value.description) {
        showMessage("Description is required.", "error");
        return;
    }
    try {
        const formData = new FormData();
        formData.append("name", params.value.name);
        formData.append("description", params.value.description);

        axios
            .post("/api/project", formData)
            .then((response) => {
                showMessage("Project has been saved successfully.", "success");

                isModalOpen.value = false;

                fetchProjects();

                closeModal();
            })
            .catch((error) => {
                showMessage("There was an error saving the project.", "error");
                console.error(error);
            });
    } catch (error) {
        console.error("An error occurred:", error);
    }
};

const deleteProject = (projectId) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to recover this project!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            axios
                .delete(`/api/project/${projectId}`)
                .then((response) => {
                    showMessage(
                        "Project has been deleted successfully.",
                        "success"
                    );
                    fetchProjects();
                })
                .catch((error) => {
                    showMessage(
                        "There was an error deleting the project.",
                        "error"
                    );
                    console.error(error);
                });
        }
    });
};

onMounted(() => {
    fetchProjects();
});

const searchProjects = () => {
    filteredProjects.value = projects.value.filter((d) =>
        d.name.toLowerCase().includes(searchQuery.value.toLowerCase())
    );
};

const showMessage = (msg = "", type = "success") => {
    const toast = Swal.mixin({
        toast: true,
        position: "top",
        showConfirmButton: false,
        timer: 3000,
        customClass: { container: "toast" },
    });
    toast.fire({
        icon: type,
        title: msg,
        padding: "10px 20px",
    });
};
</script>
