const state = {
    items: {},
    is_admin: '',
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
    async fetchItems({ commit }, page = 1) {
        try {
            const response = await axios.get(`api/items?page=${page}`);
            commit("SET_ITEMS", response.data.items);
            commit("SET_IS_ADMIN", response.data.is_admin);
            return response.data; // Return the entire response for further processing if needed
        } catch (error) {
            console.error("Error fetching items:", error);
            throw error; // Rethrow the error to handle it in the component or other Vuex actions
        }
    },

    async storeItem({ commit }, item) {
        try {
            const response = await axios.post('/api/items', item);
            return response.data; // Return the data from the response
        } catch (error) {
            console.error("Error storing item:", error);
            throw error; // Rethrow the error to handle it in the component or other Vuex actions
        }
    },

    async updateItem({ commit }, item) {
        try {
            const response = await axios.post(`/api/items/${item.id}`, {
                ...item,
                _method: 'PUT',
            });
            return response.data; // Return the data from the response
        } catch (error) {
            console.error("Error updating item:", error);
            throw error; // Rethrow the error to handle it in the component or other Vuex actions
        }
    },

    async deleteItem({ commit }, item) {
        try {
            const response = await axios.post(`/api/items/${item.id}`, {
                item,
                _method: 'DELETE',
            });
            return response.data; // Return the data from the response
        } catch (error) {
            console.error("Error deleting item:", error);
            throw error; // Rethrow the error to handle it in the component or other Vuex actions
        }
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