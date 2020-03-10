#!/usr/bin/env bash

DEPLOY_DIRECTORY="milesloveday.com"
CONNECTION="milehpsv@server187.web-hosting.com"
CONNECTION_AND_DEPLOY_DIRECTORY="$CONNECTION:$DEPLOY_DIRECTORY"
CONNECTION_AND_PUBLIC_DIRECTORY="$CONNECTION:public_html"

yarn install
if [[ "$?" -ne "0" ]]; then
    echo "Front end deps not installed correctly. Exiting."
    exit 1
else
    echo "Front end deps installed successfully"
fi

echo "WARNING: build directory needs to be manually uploaded at present"

yarn build

echo "Copying files to remote host..."
rsync -rvz --exclude ".env" --exclude ".env.local" --exclude ".git" --exclude ".idea" --exclude "assets" --exclude "infrastructure" --exclude "node_modules" --exclude "vagrant" --exclude "var" --exclude "vendor" ./ $CONNECTION_AND_DEPLOY_DIRECTORY
rsync -rvz --exclude ".htaccess" ../public_html/ $CONNECTION_AND_PUBLIC_DIRECTORY

echo "Running setup on remote host..."
ssh $CONNECTION "cd $DEPLOY_DIRECTORY ; ./setup.sh"

#echo "Creating symlink to new directory..."
#ssh admin@milesloveday.com "ln -nfs $DEPLOY_DIRECTORY/public/ /home/dashboard/public_html"
#echo "Removing old deployments..."
#ssh admin@milesloveday.com "rm -rf /home/dashboard/deploy/!($DATE)"
echo "Deployment complete"