import Router from "vue-router"
import MiddlewareRegistrator from "./MiddlewareRegistrator"

import Index from "@/views/Index"
import Repositories from "@/views/Repositories"
import Repository from "@/views/Repository"

const router = new Router({
    mode: "history",
    base: process.env.BASE_URL,
    routes: [
      {
        path: "/",
        name: "index",
        component: Index,
        meta: {
          title: "Main",
        }
      },
      {
        path: "/repositories",
        name: "repositories",
        component: Repositories,
        meta: {
          title: "Repositories",
        }
      },
      {
        path: "/repositories/:id",
        name: "repository",
        component: Repository,
        meta: {
          title: "Repository",
        }
      },
    ]
  }
)

router.beforeEach((to, from, next) => {
  if (to.meta.title) {
    document.title = `Git list - ${to.meta.title}`
  }

  next()
})

router.beforeEach(MiddlewareRegistrator(router))

export default router
