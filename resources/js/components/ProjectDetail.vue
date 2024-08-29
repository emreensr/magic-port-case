<template>
    <div class="max-w-6xl mx-auto p-6 bg-gray-50 rounded-lg shadow-md">
        <!-- Project Details -->
        <div class="mb-8">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-semibold text-gray-800 mb-4">
                    {{ project.name }}
                </h1>
                <button
                    @click="openModal"
                    class="bg-blue-500 text-white py-2 px-6 rounded-full shadow-md hover:bg-blue-600 hover:shadow-lg transition duration-300 ease-in-out transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-offset-2"
                >
                    Add Task
                </button>
            </div>
            <div>
                <p class="text-gray-600 mt-3">{{ project.description }}</p>
            </div>
        </div>

        <!-- Task List -->
        <div class="mb-6">
            <h2 class="text-3xl font-semibold text-gray-800 mb-4">Tasks</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <div
                    v-for="task in tasks"
                    :key="task.id"
                    class="p-4 bg-white rounded-lg flex flex-col justify-between items-start shadow-md hover:shadow-lg transition-shadow duration-300 ease-in-out"
                >
                    <div class="flex flex-col w-full">
                        <div
                            class="flex justify-between items-center w-full mb-2"
                        >
                            <h3 class="text-2xl font-semibold text-gray-800">
                                {{ task.name }}
                            </h3>
                            <p
                                :class="{
                                    'text-gray-600': task.status === 'todo',
                                    'text-yellow-500':
                                        task.status === 'in-progress',
                                    'text-green-500': task.status === 'done',
                                }"
                                class="font-medium capitalize"
                            >
                                {{ task.status }}
                            </p>
                        </div>
                        <p class="text-gray-700">{{ task.description }}</p>
                    </div>
                    <div class="flex space-x-2 mt-5">
                        <button
                            @click="openUpdateModal(task)"
                            class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-300"
                        >
                            Edit
                        </button>
                        <button
                            @click="deleteTask(task.id)"
                            class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition-colors duration-300"
                        >
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            v-if="addTaskModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-10 p-5"
        >
            <!-- Modal Container -->
            <div
                class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6 transform transition-transform duration-300 ease-in-out scale-100"
            >
                <!-- Modal Header -->
                <div
                    class="flex justify-between items-center border-b pb-3 mb-6"
                >
                    <h2 class="text-2xl font-semibold text-gray-800">
                        Add New Task
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
                    <form @submit.prevent="addTask">
                        <div class="mb-4">
                            <label
                                for="name"
                                class="block text-sm font-medium text-gray-700"
                                >Task Name</label
                            >
                            <input
                                v-model="newTask.name"
                                id="taskName"
                                type="text"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                placeholder="Enter task name"
                                required
                            />
                        </div>
                        <div class="mb-6">
                            <label
                                for="description"
                                class="block text-sm font-medium text-gray-700"
                                >Project Description</label
                            >
                            <textarea
                                v-model="newTask.description"
                                id="taskDescription"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                                placeholder="Enter task description"
                                required
                            ></textarea>
                        </div>
                        <div class="mb-6">
                            <label
                                for="taskStatus"
                                class="block text-sm font-medium text-gray-700"
                                >Task Status</label
                            >
                            <select
                                v-model="newTask.status"
                                id="taskStatus"
                                class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            >
                                <option value="todo">To Do</option>
                                <option value="in-progress">In Progress</option>
                                <option value="done">Done</option>
                            </select>
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
        <!-- Update Task Modal -->
        <div
            v-if="isUpdateModalOpen"
            class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center"
        >
            <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
                <div
                    class="flex justify-between items-center border-b pb-3 mb-6"
                >
                    <h2 class="text-2xl font-semibold text-gray-800">
                        Update Task
                    </h2>
                    <button
                        @click="closeUpdateModal"
                        class="text-gray-500 hover:text-gray-700 transition-colors duration-200"
                    >
                        &times;
                    </button>
                </div>
                <form @submit.prevent="updateTask" class="space-y-4">
                    <div>
                        <label
                            for="editTaskName"
                            class="block text-sm font-medium text-gray-700"
                            >Task Name</label
                        >
                        <input
                            v-model="currentTask.name"
                            id="editTaskName"
                            type="text"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required
                        />
                    </div>
                    <div>
                        <label
                            for="editTaskDescription"
                            class="block text-sm font-medium text-gray-700"
                            >Task Description</label
                        >
                        <textarea
                            v-model="currentTask.description"
                            id="editTaskDescription"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                            required
                        ></textarea>
                    </div>
                    <div>
                        <label
                            for="editTaskStatus"
                            class="block text-sm font-medium text-gray-700"
                            >Task Status</label
                        >
                        <select
                            v-model="currentTask.status"
                            id="editTaskStatus"
                            class="mt-1 p-2 w-full border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 shadow-sm"
                        >
                            <option value="todo">To Do</option>
                            <option value="in-progress">In Progress</option>
                            <option value="done">Done</option>
                        </select>
                    </div>
                    <button
                        type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition-colors duration-200"
                    >
                        Update Task
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import Swal from "sweetalert2";

const props = defineProps({
    project: {
        type: Object,
        required: true,
    },
});

const project = ref(props.project);
const tasks = ref([]);
const addTaskModal = ref(false);
const newTask = ref({ name: "", description: "", status: "todo" });
const currentTask = ref({
    id: null,
    name: "",
    description: "",
    status: "todo",
});
const isUpdateModalOpen = ref(false);

const openModal = () => {
    addTaskModal.value = true;
};

const closeModal = () => {
    addTaskModal.value = false;
};

const fetchProjectDetails = async () => {
    try {
        const response = await axios.get(
            `/api/project/show/${project.value.id}`
        );
        project.value = response.data.data;
        tasks.value = project.value.tasks;
    } catch (error) {
        console.error("Failed to fetch project details:", error);
    }
};

const addTask = async () => {
    try {
        const response = await axios.post("/api/task", {
            project_id: project.value.id,
            name: newTask.value.name,
            description: newTask.value.description,
            status: newTask.value.status,
        });
        showMessage("Task has been saved successfully.", "success");

        closeModal();

        tasks.value.push(response.data.data);
        newTask.value = { name: "", description: "", status: "todo" };
    } catch (error) {
        console.error("Failed to add task:", error);
    }
};

const openUpdateModal = (task) => {
    currentTask.value = { ...task };
    isUpdateModalOpen.value = true;
};

const closeUpdateModal = () => {
    isUpdateModalOpen.value = false;
};

const updateTask = async () => {
    try {
        const response = await axios.put(
            `/api/task/${currentTask.value.id}`,
            currentTask.value
        );
        const index = tasks.value.findIndex(
            (task) => task.id === currentTask.value.id
        );
        if (index !== -1) {
            tasks.value[index] = response.data.data;
        }

        showMessage("Task has been updated successfully.", "success");

        closeUpdateModal();
    } catch (error) {
        console.error("Failed to update task:", error);
    }
};

const deleteTask = async (taskId) => {
    try {
        await axios.delete(`/api/task/${taskId}`);

        showMessage("Task has been deleted successfully.", "success");

        tasks.value = tasks.value.filter((task) => task.id !== taskId);
    } catch (error) {
        console.error("Failed to delete task:", error);
    }
};

onMounted(fetchProjectDetails);

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
