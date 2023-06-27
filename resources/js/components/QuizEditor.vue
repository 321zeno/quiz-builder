<template>
    <div>
        <Input v-model="quiz.title" label="Quiz Title" class="mb-2"></Input>
        <Input type="text" v-model="quiz.description" class="mb-2" label="Description"></Input>

        <h2 class="text-xl font-bold mb-2">Questions</h2>
        <trivia-search></trivia-search>

    </div>
</template>

<script>
import { Input, Button, Select } from 'flowbite-vue';
import TriviaSearch from './TriviaSearch.vue';

export default {
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
            loading: true,
        }
    },
    components: {
        Input,
        Button,
        Select,
        TriviaSearch
    },
}
</script>
