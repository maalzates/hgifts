import { createStore } from 'vuex';
import campaigns from './modules/campaigns';
import items from './modules/items';
export default createStore({
  modules: {
    campaigns,
    items,
  },
});