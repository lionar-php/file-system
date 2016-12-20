# File system

## Features

- Add file to roots ( drive )

## Questions

- Allow file system modifications outside of the application or not?
- What to do with the root object ( is it good this way ? ) ?
- Allow duplicates of file system objects across different file system implementations or not?
- How to get stored file system objects?


## Issues

- Deleting an object removes it from the parent and out of the file tree but the reference will still remain 


## Alpha

- Only local file system
- Update file tree manually
- Access file system objects via file tree path