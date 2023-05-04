import moment from 'moment'

const state = {
  all_campaigns: [],
  current_user: null
};

const mutations = {
  SET_ALL_CAMPAIGNS(state, campaigns) {
    state.all_campaigns = campaigns;
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
  async fetchCampaigns({ commit }) {
    // const campaigns = await axios.get("api/campaigns?with[]=items&with[]=users");
    const campaigns = await axios.get("api/campaigns?page=${page}");
    commit("SET_ALL_CAMPAIGNS", campaigns.data);
  },

};
  
const getters = {
  // FILTER CAMPAIGNS IF DISPATCH DATE IS LATER THAN TODAY
  active_campaigns: (state) => {
    const today = moment().format('YYYY-MM-DD');
    return state.all_campaigns.filter((campaign) => campaign.dispatch_date > today);
  },

  // FILTER CAMPAIGNS IF THE USER IS SUBSCRIBED TO THE CAMPAIGN (IF EXIST IN USERS LIST LINKED TO THE CAMPAIGN)

  subscribed_campaigns: state => {
    const user = state.current_user; // WE GET THE USER
    if (!user) {
      return [];
    }
    return state.all_campaigns.filter(campaign => { // FILTER EACH CAMPAIGN TO SHOW ONLY IF MATCH A CONDDITION
      return campaign.users.some(u => u.id === user.id); // THE CONDITION IS THAT THE CURRENT USER ID SHOULD BE PRESENT IN THE CAMPAIGN USERS LIST
    });
  },

  // FILTER CAMPAIGNS IF THE USER IS SUBSCRIBED OR ACTIVE 
  subscribedOrActive: (state) => {
    return state.all_campaigns;
  }

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