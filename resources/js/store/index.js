import { createStore } from 'vuex';
import campaigns from './modules/campaigns';
import items from './modules/items';
import users from './modules/users';
import comments from './modules/comments';

export default createStore({
  modules: {
    campaigns,
    items,
    users,
    comments
  },
});