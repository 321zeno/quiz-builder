<template>
    <the-card>
        <p class="uppercase text-sm pb-3">
           {{ question.category }} | {{ question.difficulty }}
        </p>

        <p class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white mb-2">{{ question.question }}</p>
        <list-group>
            <list-group-item>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 text-green-500">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5" />
                </svg>
                {{ question.correct_answer }}
            </list-group-item>
            <list-group-item v-for="answer in question.incorrect_answers" :key="answer">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 text-yellow-500">
                    <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                </svg>
                {{ answer }}
            </list-group-item>
        </list-group>
        <slot name="footer"></slot>
    </the-card>
</template>
<script>
import {TheCard, ListGroup, ListGroupItem} from 'flowbite-vue';

export default {
    props: {
        question: {
            type: Object,
            required: true,
        },
    },
    components: {
        TheCard,
        ListGroup,
        ListGroupItem,
    },
}
</script>
