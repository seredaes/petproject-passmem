import { createRouter, createWebHistory, RouteRecordRaw } from "vue-router";

const routes: Array<RouteRecordRaw> = [
  {
    path: "/",
    name: "HomeController",
    component: () =>
      import(
        /* webpackChunkName: "HomeController" */ "../views/HomeController.vue"
      ),
  },
  {
    path: "/about",
    name: "AboutController",
    component: () =>
      import(
        /* webpackChunkName: "AboutController" */ "../views/AboutController.vue"
      ),
  },
  {
    path: "/registration",
    name: "RegistrationController",
    component: () =>
      import(
        /* webpackChunkName: "RegistrationController" */ "../views/RegistrationController.vue"
      ),
  },
  {
    path: "/dashboard",
    name: "DashboardController",
    component: () =>
      import(
        /* webpackChunkName: "DashboardController" */ "../views/DashboardController.vue"
      ),
  },
  {
    path: "/404",
    component: () =>
      import(
        /* webpackChunkName: "NotFoundController" */ "../views/NotFoundView.vue"
      ),
  },
  {
    path: "/:pathMatch(.*)*",
    redirect: "/404",
  },
];

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes,
});

router.beforeEach((to, from, next) => {
  const goToRoute = to.name;
  const excludedRoutes = ["HomeController", "RegistrationController"];
  const access_token = localStorage.getItem("access_token");

  if (!excludedRoutes.includes(goToRoute as string) && access_token === null) {
    return next("/");
  }

  return next();
});

export default router;
