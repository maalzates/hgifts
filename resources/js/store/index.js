import { createStore } from 'vuex';
import campaigns from './modules/campaigns';

export default createStore({
  modules: {
    campaigns,
  },
});