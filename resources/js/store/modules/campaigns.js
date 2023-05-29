
const state = {
  all_campaigns: [],
  active_campaigns:[],
  subscribed_campaigns: [],
  active_or_subscribed_campaigns: [],
  is_admin: null,
  current_user: null,
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

  SET_VARIABLE () {
    state.variable= 'Juan'
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

  // USER UNSUSCRIPTION FROM CAMPAIGN
  async unsubscribeAction({commit}, campaign) {
    const response = await axios.post(`api/campaigns/${campaign.id}`, {
        ...campaign,
        _method: 'PUT',    
    })
    .then((response) => {
        console.log(response);
    })
    .catch(error => {
        console.log(error);
    });

  },

  // USER SUBSCRIPTION FROM CAMPAIGN
  async subscribeAction({commit}, campaign) {
    await axios.post(`/campaigns/${campaign.id}`, {
        ...campaign,
        _method: 'PUT',    
    })
    .then((response) => {
        console.log(response);
    })
    .catch(error => {
        console.log(error);
    });
  },

  // STORE CAMPAIGNS
  async storeCampaign( {commit}, campaign) {
    await  axios.post('/api/campaigns', campaign, {
      headers: {'Content-Type': 'application/json'}
    })
      .then(res => {
          console.log(res.data);
          // window.location.href = '/campaigns/' + res.data.id + '/edit';
      })
      .catch(err => {
          console.error(err); 
      })

    // console.log(campaign);
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