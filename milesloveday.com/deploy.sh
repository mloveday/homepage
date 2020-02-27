#!/usr/bin/env bash

DATE=`date '+%Y-%m-%d-%H%M%S'`
DEPLOY_DIRECTORY="milesloveday.com"
CONNECTION="milehpsv@server187.web-hosting.com:$DEPLOY_DIRECTORY"
PRIVATE_KEY="~/.ssh/id_rsa"

yarn install
if [[ "$?" -ne "0" ]]; then
    echo "Front end deps not installed correctly. Exiting."
    exit 1
else
    echo "Front end deps installed successfully"
fi

yarn build

echo "Copying files to remote host..."
rsync -rvz --exclude ".git" --exclude ".idea" --exclude "assets" --exclude "infrastructure" --exclude "node_modules" --exclude "vagrant" --exclude "var" --exclude "vendor" ./ $CONNECTION

echo "Running setup on remote host..."
ssh $CONNECTION "cd $DEPLOY_DIRECTORY ; ./setup.sh"

#echo "Creating symlink to new directory..."
#ssh admin@milesloveday.com "ln -nfs $DEPLOY_DIRECTORY/public/ /home/dashboard/public_html"
#echo "Removing old deployments..."
#ssh admin@milesloveday.com "rm -rf /home/dashboard/deploy/!($DATE)"
echo "Deployment complete"