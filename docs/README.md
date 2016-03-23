## CI Pipeline
The pipeline is in SnapCI, the steps are defined in `.sh` files in the `pipeline` folder in the main repository.
These files are executed by each of the steps defined in SnapCI, if environment variables or artifacts
have to be configured in the pipeline, it is mentioned as a comment at the end of the file.

These are the defined steps:

#### `01-unit.sh`
In this step the unit tests are run.

#### `02-artifact.sh`
In this step the `zip` is created, excluding unwanted files and folders and using the pipeline number to identify
it. Here an artifact is defined in SnapCI in the folder `out/artifacts/Kushki`

#### `03-integration.sh`
In this step the artifact is unzipped and the integration tests are run against it.

#### `04-distribute.sh`
The `zip` from the previous step is copied to the `out/artifacts/Kushki/` folder. The latest version, `kushki.zip`,
is overwritten with the newly created one. Then these files are added to Git and pushed.