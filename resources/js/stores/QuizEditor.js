export const useQuizStore = defineStore('quiz', {
    state: () => ({
        title: '',
        description: '',
        questions: [],
    }),
    actions: {
        addQuestion(question) {
            this.questions.push(question)
        }
    }
})
