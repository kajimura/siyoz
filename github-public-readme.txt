git clone git@bitbucket.org:kajimura/siyoz.git siyoz-github4
cd siyoz-github4
rm -fr .git
sh github-public-rm.sh
rm github-public-rm.sh
git init
git remote add origin git@github.com:kajimura/siyoz.git
git add ./
git commit -m "from bitbucket to github first commit"
git push -f origin master
