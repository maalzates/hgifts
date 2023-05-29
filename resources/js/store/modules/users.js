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
        try {
            const response = await axios.get(`/api/users?page=${page}`);
            commit("SET_USERS", response.data.users);
          } catch (error) {
            console.log(error);
          }
    },

    async updateUserRoles({commit}, {user, roles}) {
        const response = await axios.post(`/api/users/${user.id}`, {
            ...roles,
            _method: 'PUT'
        })
        .then((res) => {
            console.log(res);
        })
        .catch(error => {
            console.log(error);
        });
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