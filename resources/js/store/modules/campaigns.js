import moment from 'moment'

const state = {
  all_campaigns: [],
  active_campaigns: [],
  subscribed_campaigns: [],
  active_or_subscribed_campaigns: [],
  is_admin: null,
  current_user: null
};

const mutations = {
  SET_ALL_CAMPAIGNS(state, campaigns) {
    state.all_campaigns = campaigns;
  },
  SET_ACTIVE_CAMPAIGNS(state, campaigns) {
    state.active_campaigns = campaigns;
  },
  SET_SUBSCRIBED_CAMPAIGNS(state, campaigns) {
    state.subscribed_campaigns = campaigns;
  },
  SET_ACTIVE_OR_SUBSCRIBED_CAMPAIGNS(state, campaigns) {
    state.active_or_subscribed_campaigns = campaigns;
  },
  SET_IS_ADMIN(state, is_admin) {
    state.is_admin = is_admin;
  },

  SET_USER (state, user) {
    state.current_user = user
  }
};

const actions = {

  // GET CURRENT USER INFORMATION
  async fetchUser ({ commit }) {
    try {
      const response = await axios.get('/api/user')
      const user = response.data
      commit('SET_USER', user)
    } catch (error) {
      console.log(error)
    }
    
  },

  // GET CURRENT CAMPAIGNS INFORMATION
  async fetchCampaigns({ commit }, page = 1) {
    // const campaigns = await axios.get("api/campaigns?with[]=items&with[]=users");
    const response = await axios.get(`api/campaigns?page=${page}`);

    commit("SET_ALL_CAMPAIGNS", response.data.campaigns);
    commit("SET_ACTIVE_CAMPAIGNS", response.data.active_campaigns);
    commit("SET_SUBSCRIBED_CAMPAIGNS", response.data.subscribed_campaigns);
    commit("SET_ACTIVE_OR_SUBSCRIBED_CAMPAIGNS", response.data.active_or_subscribed_campaigns);
    commit("SET_IS_ADMIN", response.data.is_admin);
  },

};
  
const getters = {
};

export default {
  namespaced: true,
  state,
  mutations,
  actions,
  getters,
};



// const state = {
//     campaigns: [],
//   };
  
//   const mutations = {
//     SET_CAMPAIGNS(state, campaigns) {
//       state.campaigns = campaigns;
//     },
//     ADD_CAMPAIGN(state, campaign) {
//       state.campaigns.push(campaign);
//     },
//     UPDATE_CAMPAIGN(state, updatedCampaign) {
//       const index = state.campaigns.findIndex(
//         (campaign) => campaign.id === updatedCampaign.id
//       );
//       state.campaigns.splice(index, 1, updatedCampaign);
//     },
//     DELETE_CAMPAIGN(state, campaignId) {
//       state.campaigns = state.campaigns.filter(
//         (campaign) => campaign.id !== campaignId
//       );
//     },
//   };
  
//   const actions = {
//     async fetchCampaigns({ commit }) {
//       const campaigns = await axios.get("/api/campaigns");
//       commit("SET_CAMPAIGNS", campaigns.data);
//     },
//     async addCampaign({ commit }, campaign) {
//       const newCampaign = await axios.post("/api/campaigns", campaign);
//       commit("ADD_CAMPAIGN", newCampaign.data);
//     },
//     async updateCampaign({ commit }, updatedCampaign) {
//       const response = await axios.put(
//         `/api/campaigns/${updatedCampaign.id}`,
//         updatedCampaign
//       );
//       commit("UPDATE_CAMPAIGN", response.data);
//     },
//     async deleteCampaign({ commit }, campaignId) {
//       await axios.delete(`/api/campaigns/${campaignId}`);
//       commit("DELETE_CAMPAIGN", campaignId);
//     },
//   };
  
//   const getters = {
//     campaigns: (state) => state.campaigns,
//   };
  
//   export default {
//     namespaced: true,
//     state,
//     mutations,
//     actions,
//     getters,
//   };