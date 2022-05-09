const FormHelper = {
    createForm() {
        return {
            comment: {
                error: '',
                value: '',
            }
        };
    },
    createFormByComment(comment) {
        return {
            id: {
                error: '',
                value: comment.id,
            },
            comment: {
                error: '',
                value: comment.comment,
            }
        };
    },
    formToMutation(commentForm) {
        const mutation = {};
        if (commentForm.id) {
            mutation.id = commentForm.id.value;
        } else {
            mutation.id = 0;
        }

        if (commentForm.comment) {
            mutation.comment = commentForm.comment.value;
        }

        return mutation;
    },
    loadErrorsToForm(form, errors) {
        if (!errors) {
            return;
        }

        for (const [property, error] of Object.entries(errors)) {
            if (form[property]) {
                form[property].error = error;
                continue;
            }

            throw error;
        }
    },
}

export default FormHelper;