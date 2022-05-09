import axios from "axios";

const CommentRepository = {
    getAll: async function () {
        const response = await axios.get('/comments');
        if (200 === response.status) {
            return response.data.data;
        }

        throw response.data;
    },
    removeById: async function (id) {
        const response = await axios.delete(`/comment/${id}`);
        if (200 === response.status) {
            return response.data.data;
        }

        throw response.data;
    },
    createOrUpdate: async function (comment) {
        const response = await axios.post(`/comment`, {input: comment});
        if (200 === response.status) {
            return response.data.data;
        }

        throw response.data;
    },
};

export default CommentRepository;