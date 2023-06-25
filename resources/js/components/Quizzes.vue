<template>
    <div>
        <h1>Quizzes</h1>
        <p v-if="loading">Loading...</p>
        <p v-else>
            <p v-if="!quizzes">It looks like there are no quizes</p>
            <section>
                <article v-for="quiz in quizzes" :key="quiz.id" class="flex flex-row items-center p-5 my-10 border">
                    <a :href="`/quiz/${quiz.id}`" class="text-xl">
                        {{ quiz.title }}
                    </a>
                    <a :href="`/quiz/${quiz.id}`" class="text-blue-700 ml-auto">
                        Edit
                    </a>
                    <span class="px-3">|</span>
                    <a href="#" @click="remove(quiz.id)" class="text-yellow-700">
                        Delete
                    </a>
                </article>
            </section>
            <a href="/quiz/create" class="mt-3 block">
                <Button color="default">Create a quiz</Button>
            </a>
        </p>
    </div>
</template>
<script>
import axios from 'axios';
import { Button } from 'flowbite-vue'

export default {
    name: "Quizzes",
    data() {
        return {
            quizzes: [],
            loading: true,
        }
    },
    async created() {
        try {
            const response = await axios.get(`/json/quizzes`);
            this.quizzes = response.data;
            this.loading = false;
        } catch (error) {
            console.error(error);
            this.loading = false;
        }
    },
    components: {
        Button
    }
}
</script>
