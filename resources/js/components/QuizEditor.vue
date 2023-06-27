<template>
    <div>
        <div class="flex justify-between mb-2">
            <Button @click="back()" size="lg" color="alternative">Back</Button>
            <Button @click="save()" size="lg" color="purple" :disabled="saving">Save</Button>
        </div>
        <div class="mb-2 mt-2">
            <Input v-model="quiz.title" label="Quiz Title"></Input>
            <p v-if="errors.title" class="text-red-500 text-sm">{{ errors.title.join(' ') }}</p>
        </div>
        <div class="mb-2">
            <Input type="text" v-model="quiz.description" class="mb-2" label="Description"></Input>
            <p v-if="errors.description" class="text-red-500 text-sm mb-2">{{ errors.description.join(' ') }}</p>
        </div>
        <h2 class="text-xl font-bold mb-2">Questions:</h2>
        <p v-if="errors.questions" class="text-red-500 text-sm mb-2">{{ errors.questions.join(' ') }}</p>
        <div class="grid grid-cols-2 gap-4">
            <question-card v-for="question in quiz.questions" :key="question.question" :question="question">
                <template v-slot:footer>
                    <div class="flex justify-end">
                        <Button @click="removeFromQuiz(question)" color="red">Remove</Button>
                    </div>
                </template>
            </question-card>
        </div>

        <trivia-search class="mt-3"></trivia-search>
    </div>
</template>

<script>
import { Input, Button, Select } from 'flowbite-vue';
import TriviaSearch from './TriviaSearch.vue';
import QuestionCard from './QuestionCard.vue';
import {useQuizEditorStore} from '../stores/QuizEditor';
import { storeToRefs } from "pinia"

export default {
    props: {
        quizId: {
            required: false,
        },
    },
    data() {
        return {
            quiz: {
                title: '',
                description: '',
                questions: [],
            },
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
            errors: {},
            loading: true,
            saving: false,
        }
    },
    methods: {
        removeFromQuiz(question) {
            this.quiz.questions = this.quiz.questions.filter(q => q.question !== question.question);
        },
        async save(quiz) {
            this.saving = true;
            await axios.post('/json/quizzes', this.quiz)
                .then(response => {
                    this.saving = false;
                    window.location.href = '/dashboard/';
                })
                .catch(error => {
                    this.saving = false
                    if (error.response.status === 422) {
                        this.errors = error.response.data.errors
                    }
                })
        },
        back() {
            window.location.href = '/dashboard/';
        },
    },
    created() {
        if (this.quizId) {
            axios.get(`/quiz/${this.quizId}/json`)
                .then(response => {
                    this.quiz = response.data;
                    this.loading = false;
                })
                .catch(error => {
                    console.log(error);
                })
        } else {
            this.loading = false;
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
        TriviaSearch,
        QuestionCard
    },
}
</script>
<style>
.grid-cols-2 {
    grid-template-columns: repeat(2, minmax(0, 1fr));
}
</style>
