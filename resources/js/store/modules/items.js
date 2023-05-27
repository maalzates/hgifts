

const state = {
    items: {},
    is_admin: null,
};

const mutations = {
    SET_IS_ADMIN(state, is_admin){
        state.is_admin = is_admin;
    },
    SET_ITEMS(state, items) {
        state.items = items;
    },
};

const actions = {
    async fetchItems({commit}, page = 1) {
        const response = await axios.get(`api/items?page=${page}`);
        console.log(response);
        commit("SET_ITEMS", response.data.items);
        commit("SET_IS_ADMIN", response.data.is_admin);
    },

    async storeItem({commit}, item) {
        const response = axios.post('/api/items',item)
            .then(res => {
                console.log(response);
                return res
            })
            .catch(err => {
                return err
            })
        
    }
};

const getters = {};

export default {
    namespaced: true,
    state,
    mutations,
    actions,
    getters,
  };