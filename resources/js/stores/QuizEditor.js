import { defineStore } from 'pinia'

export const useQuizEditorStore = defineStore('quiz', {
    state: () => ({
        quiz: {
            id: null,
            title: '',
            description: '',
            questions: [],
        }
    }),
    actions: {
        addQuestion(question) {
            this.questions.push(question)
        }
    }
})
