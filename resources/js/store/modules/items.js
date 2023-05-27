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
    },
    async updateItem({commit}, item) {
        const response = await axios.post(`/api/items/${item.id}`, {
                ...item,
                _method: 'PUT',    
            })
            .then((response) => {
                // window.location.href = this.route('items.index');
                console.log(response);
            })
            .catch(error => {
                console.log(error);
            });
    },
    async deleteItem({commit}, item ){
        // console.log(item);
        const response = await axios.post(`/api/items/${item.id}`, {
                item,
                _method: 'DELETE',    
            })
        .then(response => {
            // window.location.href = this.route('items.index');
            console.log(response);
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
    getters,
  };