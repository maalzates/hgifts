
const state = {
  all_campaigns: [],
  active_campaigns:[],
  subscribed_campaigns: [],
  active_or_subscribed_campaigns: [],
  is_admin: '',
  current_user: null,
  users: null,
  comments: [],
  scores: null,
  average: null,
  has_rated: null
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
    state.active_or_subscribed_campaigns =  campaigns;
  },
  SET_IS_ADMIN(state, is_admin) {
    state.is_admin = is_admin;
  },
  SET_USER (state, user) {
    state.current_user = user
  },
  SET_USERS (state, users) {
    state.users = users
  },
  SET_COMMENTS (state, comments) {
    state.comments = comments
  },
  SET_SCORES (state, scores) {
    state.scores = scores
  },
  SET_AVERAGE (state, average) {
    state.average = average
  },
  SET_HAS_RATED (state, has_rated) {
    state.has_rated = has_rated
  },
  SET_CURRENT_USER (state, current_user) {
    state.current_user = current_user
  },

};

const actions = {

  // GET CURRENT USER INFORMATION
  async fetchUser({ commit }) {
    try {
      const response = await axios.get('/api/user');
      const user = response.data;
      commit('SET_USER', user);
    } catch (error) {
      console.error('Error fetching user information:', error);
      throw error; // Rethrow the error for handling in components
    }
  },

  // GET CURRENT CAMPAIGNS INFORMATION
  async fetchCampaigns({ commit }, page = 1) {
    try {
      const response = await axios.get(`api/campaigns?page=${page}`);
      commit("SET_ALL_CAMPAIGNS", response.data.campaigns);
      commit("SET_ACTIVE_CAMPAIGNS", response.data.active_campaigns);
      commit("SET_SUBSCRIBED_CAMPAIGNS", response.data.subscribed_campaigns);
      commit("SET_ACTIVE_OR_SUBSCRIBED_CAMPAIGNS", response.data.active_or_subscribed_campaigns);
      commit("SET_IS_ADMIN", response.data.is_admin);
    } catch (error) {
      console.error('Error fetching campaigns information:', error);
      throw error; // Rethrow the error for handling in components
    }
  },

  // USER UNSUSCRIPTION FROM CAMPAIGN
  async unsubscribeAction({ commit }, campaign) {
    try {
        const response = await axios.post(`api/campaigns/${campaign.id}`, {
            ...campaign,
            _method: 'PUT',    
        });
        console.log(response);
    } catch (error) {
        console.log(error);
    }
  },

  // USER UNSUBSCRIPTION FROM CAMPAIGN
  async unsubscribeAction({ commit }, campaign) {
    try {
      const response = await axios.post(`api/campaigns/${campaign.id}`, {
        ...campaign,
        _method: 'PUT',
      });
      console.log(response);
    } catch (error) {
      console.error('Error unsubscribing from campaign:', error);
      throw error; // Rethrow the error for handling in components
    }
  },

  // USER SUBSCRIPTION TO CAMPAIGN
  async subscribeAction({ commit }, campaign) {
    try {
      const response = await axios.post(`api/campaigns/${campaign.id}`, {
        ...campaign,
        _method: 'PUT',
      });
      console.log(response);
    } catch (error) {
      console.error('Error subscribing to campaign:', error);
      throw error; // Rethrow the error for handling in components
    }
  },

  // STORE CAMPAIGN
  async storeCampaign({ commit }, campaign) {
    try {
      const response = await axios.post('/api/campaigns', campaign, {
        headers: { 'Content-Type': 'application/json' },
      });
      console.log(response);
      // window.location.href = '/campaigns/' + response.data.id + '/edit';
      window.location.href = '/campaigns/';
    } catch (error) {
      console.error('Error storing campaign:', error);
      throw error; // Rethrow the error for handling in components
    }
  },

  // UPDATE CAMPAIGN
  async updateCampaign({ commit }, { current_campaign, updated_campaign }) {
    try {
      const response = await axios.post(
        `/api/campaigns/${current_campaign.id}`,
        {
          ...updated_campaign,
          _method: 'PUT',
        },
        {
          headers: { 'Content-Type': 'application/json' },
        }
      );
      console.log(response);
    } catch (error) {
      console.error('Error updating campaign:', error);
      throw error; // Rethrow the error for handling in components
    }
  },

  // DELETE CAMPAIGN
  async deleteCampaign({ commit }, campaign) {
    try {
      const response = await axios.post(`/api/campaigns/${campaign.id}`, {
        ...campaign,
        _method: 'DELETE',
      });
      console.log(response);
      // window.location.href = this.route('campaigns.index');
    } catch (error) {
      console.error('Error deleting campaign:', error);
      throw error; // Rethrow the error for handling in components
    }
  },

  // FETCH CAMPAIGN SHOW VIEW INFO
  async fetchCampaignShowInfo({ commit }, campaign) {
    try {
      const response = await axios.get(`/api/campaigns/${campaign.id}/show`);
      commit('SET_USERS', response.data.users);
      commit('SET_COMMENTS', response.data.comments);
      commit('SET_SCORES', response.data.scores);
      commit('SET_AVERAGE', response.data.average);
      commit('SET_HAS_RATED', response.data.has_rated);
      commit('SET_CURRENT_USER', response.data.current_user);
      commit('SET_IS_ADMIN', response.data.is_admin);
      console.log('response:', response.data.comments);
    } catch (error) {
      console.error('Error fetching campaign info:', error);
      throw error; // Rethrow the error for handling in components
    }
  }

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