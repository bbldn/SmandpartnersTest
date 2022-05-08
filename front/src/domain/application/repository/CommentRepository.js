import axios from "axios";

const CommentRepository = {
    getAll: async function () {
        const response = await axios.get('/comments');
        if (200 === response.status) {
            return response.data.data;
        }

        return [];
    },
    removeById: async function (id) {
        const response = await axios.delete(`/comment/${id}`);
        if (200 === response.status) {
            return response.data.data;
        }

        return false;
    },
    createOrUpdate: async function (comment) {
        const response = await axios.post(`/comment`, {input: comment});
        if (200 === response.status) {
            return response.data.data;
        }

        return null;
    },
};

export default CommentRepository;