import Vue from 'vue';
import VueRouter from 'vue-router';
import NProgress from 'nprogress';
import { NProgressConfig } from '~/config';
import { staticRoutes } from '~/router/routes/static';

Vue.use(VueRouter);

NProgress.configure(NProgressConfig);

const router = new VueRouter({
  mode: 'history',
  routes: staticRoutes
});

router.beforeResolve(async(to, from, next) => {
  if (to !== from) {
    NProgress.start();
  }
  
  next();
});

router.afterEach(() => {
  NProgress.done();
});

export default router;
