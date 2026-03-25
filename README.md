# Redirect

Redirect paths to another domain running as a service on Google Cloud Run

# Install

If you have not already verified ownership of the domain in [Google Search Console](https://search.google.com/search-console/), you will need to add it as a property there first and verify ownership.

Clone the repo, install dependencies, deploy to Google Cloud Run.

```bash
git clone git@github.com:groton-school/redirect.git path/to/repo
cd path/to/repo
pnpm install
pnpm run deploy
```

Once deployed to Google Cloud Run, visit the [Cloud Run Domain Mappings](https://console.cloud.google.com/run/domains) and add a mapping to the desired domain. It will take 30-60 minutes for the domain to map and SSL cert to be issued.

# Usage

Out of the box, all redirects are pointed to our Veracross Portals host. The PHP script is simply replacing `https://portals.groton.org` with `https://portals.veracross.com/groton` in its redirect. Edit [app/index.php](./app/index.php) and re-deploy (`pnpm run deploy`) to adjust your redirect.