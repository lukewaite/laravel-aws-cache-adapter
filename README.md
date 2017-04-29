# laravel-aws-cache-adapter
> Provides an `Aws\CacheInterface\CacheInterface` compliant cache for the AWS SDK which uses the laravel Cache classes.

### Purpose
When using EC2 Instance IAM Roles or ECS Task IAM Roles the AWS php sdk automatically performs lookups against the ec2
metadata api (169.254.169.254) to get credentials. These by default are not cached, and can occasionally be a source
of trouble or slowdowns if the metadata api is slow/not responding.

This package allows you to configure certain laravel filesystems to be automatically loaded with a `CacheInterface` that
will use a laravel cache store to cache the STS tokens returned, reducing requests to the metadata api.

