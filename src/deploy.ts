import gcloud from "@battis/partly-gcloudy";
import { Core } from "@qui-cli/core";
import {Env} from '@qui-cli/env'

const {
  values: { force, user: users = [] },
} = await Core.init({
  flag: {
    force: {
      description: "Force (re)running the setup wizard.",
      short: "f",
    },
  },
});

const wizard = force || !(await Env.get({key: 'PROJECT'}));

if (wizard) {
  await gcloud.batch.run.initialize({
    defaultName: "Redirect",
    env: true,
  });
}
const project = gcloud.projects.active.get();
const { service } = await gcloud.batch.run.deployService({
  env: true,
  region: await Env.get({key: 'REGION'}),
  serviceName: await Env.get({key: 'SERVICE_NAME'}),
  args: {
    source: "./app",
    "allow-unauthenticated": true,
  },
});
