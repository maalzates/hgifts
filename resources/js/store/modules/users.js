const state = {
    users: []
};
const mutations = {
    SET_USERS(state, users){
        state.users = users;
    },
};
const actions = {
    async fetchUsers({commit}, page = 1) {
        const response = await axios.get(`/api/users?page=${page}`);
        commit("SET_USERS", response.data.users);
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