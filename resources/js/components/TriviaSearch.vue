<template>
    <div class="border p-5">
        <div>
            Search for trivia
        </div>
        <div class="flex flex-row">
            <Select v-model="triviaFilters.category" :options="categories" label="Category" placeholder="Random"/>
            <Select v-model="triviaFilters.difficulty" :options="difficulties" class="ml-2" label="Difficulty" placeholder="Random"/>
            <Select v-model="triviaFilters.type" :options="types" class="ml-2" label="Type" placeholder="Random"/>
            <Button @click="search" color="default" class="ml-2 h26rem mt18rem">Search</Button>
        </div>
        <div>
            <div v-if="loading" class="mt-4">
                <spinner class="mx-auto"/>
            </div>
            <div v-else-if="trivia.question">
                <question-card class="mt-4" :question="trivia">
                    <template v-slot:footer>
                        <div class="flex justify-end">
                            <Button @click="addToQuiz" color="green">Add To Quiz</Button>
                        </div>
                    </template>
                </question-card>
            </div>
            <div v-else>
                <p class="mb-2 p-5 text-center">Press "Search" to select a question for the quiz</p>
            </div>
        </div>
    </div>
</template>
<script>
import { Input, Button, Select, Spinner} from 'flowbite-vue';
import QuestionCard from './QuestionCard.vue';
import {useQuizEditorStore} from '../stores/QuizEditor';
import { storeToRefs } from "pinia"

export default {
    data() {
        return {
            categories: [],
            difficulties: [
                {
                    name: 'Easy',
                    value: 'easy',
                },
                {
                    name: 'Medium',
                    value: 'medium',
                },
                {
                    name: 'Hard',
                    value: 'hard',
                }
            ],
            types: [
                {
                    name: 'Multiple Choice',
                    value: 'multiple',
                },
                {
                    name: 'True / False',
                    value: 'boolean',
                },
            ],
            triviaFilters: {
                category: '',
                difficulty: '',
                type: '',
            },
            trivia: {
                category: '',
                type: '',
                difficulty: '',
                question: '',
                correct_answer: '',
                incorrect_answers: [],
            },
            loading: false,
        }
    },
    methods: {
        async search() {
            try {
                this.loading = true;
                const response = await axios.post(`/json/trivia/search`, {
                    ...this.triviaFilters,
                });
                this.loading = false;
                this.trivia = response.data;
            } catch (error) {
                console.error(error);
                this.loading = false;
            }
        },
        addToQuiz() {
            this.quiz.questions.push(this.trivia);
            this.trivia = {
                category: '',
                type: '',
                difficulty: '',
                question: '',
                correct_answer: '',
                incorrect_answers: [],
            };
        }
    },
    async created() {
        try {
            const response = await axios.get(`/json/trivia/categories`);
            this.categories = response.data;
        } catch (error) {
            console.error(error);
        }
    },
    setup() {
        const quizEditorStore = useQuizEditorStore();
        const { quiz } = storeToRefs(quizEditorStore);

        return {
            quiz,
        }
    },
    components: {
        Input,
        Button,
        Select,
        QuestionCard,
        Spinner
    },
}
</script>
<style scoped>
.h26rem {
    height: 2.6rem;
}
.mt18rem {
    margin-top: 1.8rem;
}
</style>
