#include <string.h>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include "mytar.h"

extern char *use;

/** Copy nBytes bytes from the origin file to the destination file.
 *
 * origin: pointer to the FILE descriptor associated with the origin file
 * destination:  pointer to the FILE descriptor associated with the destination file
 * nBytes: number of bytes to copy
 *
 * Returns the number of bytes actually copied or -1 if an error occured.
 */
int
copynFile(FILE * origin, FILE * destination, int nBytes)
{
	// Complete the function
	int byte = getc(origin);
	int bytesCopied = 0;

	while((byte != (int) EOF) && bytesCopied <	nBytes)//si llegamos al final del archivo o hemos copiado ya el numero de bytes especificafos
	{
		putc(byte, destination);
		bytesCopied++;
		if(bytesCopied < nBytes)//arregla el error mencionado abajo
			byte = getc(origin);
		
	}
//---si sale del bucle porque se alcanzo el limitede bytes lee un byte mas que no deberia (problemas en extract tar)
	return bytesCopied;

	//return -1;
}

/** Loads a string from a file.
 *
 * file: pointer to the FILE descriptor 
 * 
 * The loadstr() function must allocate memory from the heap to store 
 * the contents of the string read from the FILE. 
 * Once the string has been properly built in memory, the function returns
 * the starting address of the string (pointer returned by malloc()) 
 * 
 * Returns: !=NULL if success, NULL if error
 */
char*
loadstr(FILE * file)
{
	
	// Complete the function
	int c;
	c = getc(file);
	int nChars = 0;

	while(c != (int)'\0')
	{
		nChars++;
		c = getc(file);
	}

	char* str = malloc(sizeof(char) * (nChars +1));

	fseek(file, -sizeof(char) * (nChars+1), SEEK_CUR);

	fread(str, sizeof(char) * (nChars +1),1,file);

	return str;
	//return NULL;
}

/** Read tarball header and store it in memory.
 *
 * tarFile: pointer to the tarball's FILE descriptor 
 * nFiles: output parameter. Used to return the number 
 * of files stored in the tarball archive (first 4 bytes of the header).
 *
 * On success it returns the starting memory address of an array that stores 
 * the (name,size) pairs read from the tar file. Upon failure, the function returns NULL.
 */
stHeaderEntry*
readHeader(FILE * tarFile, int *nFiles)
{
	fread(nFiles, sizeof(int), 1, tarFile);

	stHeaderEntry* header = malloc(sizeof(stHeaderEntry) * (*nFiles));

	for(int i = 0; i < *nFiles; i++)
	{
		header[i].name = loadstr(tarFile);
		fread(&(header[i].size), sizeof(int), 1, tarFile);
	}

	return header;
}

/** Creates a tarball archive 
 *
 * nfiles: number of files to be stored in the tarball
 * filenames: array with the path names of the files to be included in the tarball
 * tarname: name of the tarball archive
 * 
 * On success, it returns EXIT_SUCCESS; upon error it returns EXIT_FAILURE. 
 * (macros defined in stdlib.h).
 *
 * HINTS: First reserve room in the file to store the tarball header.
 * Move the file's position indicator to the data section (skip the header)
 * and dump the contents of the source files (one by one) in the tarball archive. 
 * At the same time, build the representation of the tarball header in memory.
 * Finally, rewind the file's position indicator, write the number of files as well as 
 * the (file name,file size) pairs in the tar archive.
 *
 * Important reminder: to calculate the room needed for the header, a simple sizeof 
 * of stHeaderEntry will not work. Bear in mind that, on disk, file names found in (name,size) 
 * pairs occupy strlen(name)+1 bytes.
 *
 */

//1 que oaunte directamente a filenames de x. No hacer
//1 reservar espacio con malloc en funcion d elo largo que sea el nombre
//copiar via strcpy desde filenames posicion correcpondiente al buffer que acabamos de reservar


int
createTar(int nFiles, char *fileNames[], char tarName[])
{
	// Complete the function
	FILE* tar;
	if(nFiles == 0)
	{
		err(1,"At least one file is necesary for create a tar file");// seria mejor un pritnf con el mensaje, y un exit failure??
	}
	//TODO comprobar abierto correctamente y hacer mensaje error
	tar = fopen(tarName, "w+"); //crea el fichero con el nombre dado y permisos de escritura y tambien lectura para depurar
	if(tar == NULL)
	{
		err(1,"The tar file %s could not be opened",tarName);
	}
	//stHeaderEntry head[] = malloc(sizeof(stHeaderEntry)*nFiles); //reservamos memoria para los datos del header;
	stHeaderEntry* head = malloc(sizeof(stHeaderEntry)*nFiles); //reservamos memoria para los datos del header;

	//anotacion lab: leer via loadstr a un buffer que hayamos creado (para el texto)
	//malloc(sizeof(stHeaderEntry)*nFiles); //reservamos memoria para los datos del header
	
	for(int i = 0; i< nFiles; i++)
	{
		//FILE* file = fopen(fileNames[i],"r");
		//char* name = malloc(sizeof(fileNames[i]) + 1);//reservamos mem para el nombre y un byte mas para el \0  (+1 suma un byte porque char es de 1 byte, si fuera int sumaria 4 bytes)
		char* name = malloc(sizeof(char) * (strlen(fileNames[i]) + 1));
		//char* name = loadstr(file);
		head[i].name = name; //hacemos que el puntero del struct apunte al nombre
		strcpy(head[i].name, fileNames[i]);

		//strcat(head[i].name, "\0");
		strcat(head[0].name, "\0");//no concatena el \0 quizas porque el texto no tiene el caracter \0 y entonces no funciona la funcion
		//fclose(file);
	}
	


//pero no estamos reservando memoria
/*	for(int i = 0; i< nFiles; i++)
	{
		char* name = malloc(sizeof(fileNames[i]));
		*name = fileNames[i];

	
	head[i].name = fileNames[i];

	}*/

	//reservamos espacio en el fichero destino tar para la cabecera (ya correcto)
	long offset = sizeof(int) + nFiles * sizeof (unsigned int);
	for(int i = 0; i < nFiles; i++)
	{
		offset += (strlen(fileNames[i])+1);
	}

	fseek(tar,offset, SEEK_SET);//puntero a la zona de info

	

	for(int i = 0; i< nFiles; i++)
	{
		FILE* inputFile = fopen(fileNames[i], "r");

		if(inputFile == NULL)
		{
			err(1,"The file %s could not be opened",fileNames[i]);
		}

		int bytesCopied = copynFile(inputFile, tar, INT_MAX);

		fclose(inputFile);

		head[i].size = bytesCopied;
	}

	//nos posicionamos al inicio del fichero
	fseek(tar,0,SEEK_SET);


	fwrite(&nFiles, sizeof(int),1,tar);//escribimos el numero de ficheros


//escribimos la info dle nombre y numero de bytes
for(int i = 0; i < nFiles; i++)//en picncipio estaria bien, al menos el nombre dle fichero
{
	//fwrite(head[i].name,sizeof(head[i].name),1, tar);//escribimos la ruta del fichero. Si no probar con strlen
	fwrite(head[i].name,sizeof(char) * strlen(head[i].name),1, tar);
//------------------------------------------------------------------------------------------------------------------------------
	fwrite("\0",sizeof(char),1, tar);//no se si es correcto hacer eso o deberia de estar ya en el campo name-------------------------
	//porque strcart no funciona para ponerle el \0 (segun documentacion, para que funcione strcat ambas cadenas necesitan tener \0)

	fwrite(&(head[i].size),sizeof(unsigned int),1, tar);
}
	
	for(int i = 0; i < nFiles; i++)
	{
		free(head[i].name);//liberamos la memoria reservada para name
	}

	free(head);

	
	//free(head);//habria que ir uno a uno las posiciones de head liberando el nombre que esta en un buffer, y luego hacer free head
	fclose(tar);
	printf("Mtar file created successfully\n");
	return EXIT_SUCCESS;
	//return EXIT_FAILURE;
}

/** Extract files stored in a tarball archive
 *
 * tarName: tarball's pathname
 *
 * On success, it returns EXIT_SUCCESS; upon error it returns EXIT_FAILURE. 
 * (macros defined in stdlib.h).
 *
 * HINTS: First load the tarball's header into memory.
 * After reading the header, the file position indicator will be located at the 
 * tarball's data section. By using information from the 
 * header --number of files and (file name, file size) pairs--, extract files 
 * stored in the data section of the tarball.
 *
 */
int
extractTar(char tarName[])
{
	// Complete the function

	FILE* tar = fopen(tarName,"r");

	if(tar == NULL)
	{
		err(2,"The tar file %s could not be opened",tarName);
	}

	int nfiles;
	stHeaderEntry* head = readHeader(tar,&nfiles);//nfiles se lee bien

	for(int i = 0; i < nfiles; i++)
	{
		FILE* files = fopen(head[i].name,"w");

		if(tar == NULL)
		{
			err(2,"The file %s could not be opened",head[i].name);
		}
		printf("[%d] Creating file %s, size %d Bytes...", i, head[i].name, head[i].size);
		copynFile(tar, files, head[i].size);//puede dar error???---------------
		printf("Ok\n");

		fclose(files);

	}
//en el segundo pone que son 66(asci: B) bytes pero solo hay 65 caracteres. Hay un salto de linea escondido que no se ve? Tendria sentido por ejemplo con cat

	for(int i = 0; i < nfiles; i++)
	{
		free(head[i].name);//liberamos la memoria reservada para name
	}

	free(head);
	
	return EXIT_SUCCESS;

	//return EXIT_FAILURE;
}
