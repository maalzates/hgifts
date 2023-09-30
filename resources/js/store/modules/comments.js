const state = {
    comments: {}
};
const mutations = {
    SET_COMMENTS(state, comments){
        state.comments = comments;
    }
};
const actions = {
    async storeComment({commit}, comment) {
        try {
            const response = await axios.post('/api/comments', comment);
            commit('SET_COMMENTS', response.data);
            // console.log(response.data);
        } catch (error) {
            console.log(error);
        }
    }
};
const getters = {};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters
}