



const state = {
    all_campaigns: [],
  };
  
  const mutations = {
    SET_ALL_CAMPAIGNS(state, campaigns) {
      state.all_campaigns = campaigns;
    },
  };
  
  const actions = {
    async fetchCampaigns({ commit }) {
      const campaigns = await axios.get("api/campaigns");
      commit("SET_ALL_CAMPAIGNS", campaigns.data);
    }
  };
  
 const getters = {
    activeCampaigns: state => {
        const today = new Date().toISOString().slice(0, 10)
        return state.all_campaigns.filter(campaign => new Date(campaign.dispatch_date) > new Date(today));
        // return state.all_campaigns.filter(campaign => campaign.dispatch_date > today)
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