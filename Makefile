AWS_REGION="us-east-1"
AWS_PROFILE="default"
DOCKER_LOGIN=$(shell aws ecr get-login --region=$(AWS_REGION) --profile=$(AWS_PROFILE))
ecr-login:
	@echo Getting an ECR Login Token
	$(DOCKER_LOGIN)

build-container:
	docker build -t helpmeabstract/api:base .
	@echo "FROM helpmeabstract/api:base" > Dockerfile.distrib
	docker build -t helpmeabstract/api:latest -f Dockerfile.distrib .

tag-container: ecr-login build-container
	@echo Tagging current container state in ECR
	docker tag helpmeabstract/api:latest 976623053519.dkr.ecr.us-east-1.amazonaws.com/helpmeabstract/api:latest

deploy-container: ecr-login tag-container
	@echo Pushing container to ECR
	docker push 976623053519.dkr.ecr.us-east-1.amazonaws.com/helpmeabstract/api:latest

deploy-staging: deploy-container
	@echo Deploying to staging
	php scripts/ecs_deploy.php $(AWS_PROFILE) $(AWS_REGION) helpmeabstract-staging helpmeabstract-api

run-local-migrations: build-container
	docker run -i --rm -w /var/www --sig-proxy=true --pid=host -v `pwd`:/var/www --network="api_default" -e "MYSQL_USER=helpmeabstract" -e "MYSQL_PASSWORD=securelol" helpmeabstract/api bin/console migrations:migrate
