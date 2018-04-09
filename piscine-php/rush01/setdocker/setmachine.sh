export MACHINE_STORAGE_PATH=/Volumes/Storage/goinfre/wzaim
docker-machine create -d virtualbox piscine
eval $(docker-machine env piscine)
