#include <unistd.h>
#include <stdlib.h>
#include <fcntl.h>
#include <stdio.h>
#include <termios.h>

// 992(*4)..2000(*4) or a range of 3968..8000
int maestroGetPosition(int fd, unsigned char channel)
{
  unsigned char command[] = {0x90, channel};
  if(write(fd, command, sizeof(command)) == -1)
  {
    perror("error writing");
    return -1;
  }

  unsigned char response[2];
  if(read(fd,response,2) != 2)
  {
    perror("error reading");
    return -1;
  }

  return response[0] + 256*response[1];
}


// Sets the target of a Maestro channel.
// See the "Serial Servo Commands" section of the user's guide.
// The units of 'target' are quarter-microseconds.
int maestroSetTarget(int fd, unsigned char channel, unsigned short target)
{
  unsigned char command[] = {0x84, channel, target & 0x7F, target >> 7 & 0x7F};
  if (write(fd, command, sizeof(command)) == -1)
  {
    perror("error writing");
    return -1;
  }
  return 0;
}
int main(int argc, char *argv[])
{
  int target = 0;
  int opt;
  const char * device = "/dev/ttyACM0";  // Linux
  int fd = open(device, O_RDWR | O_NOCTTY);
  if (fd == -1) {
    perror(device);
    return 1;
  }
#ifndef _WIN32
  struct termios options;
  tcgetattr(fd, &options);
  options.c_lflag &= ~(ECHO | ECHONL | ICANON | ISIG | IEXTEN);
  options.c_oflag &= ~(ONLCR | OCRNL);
  tcsetattr(fd, TCSANOW, &options);
#endif

  while ((opt = getopt(argc, argv, "t:")) != -1) {
	switch (opt) {
		case 't':
			target = atoi(optarg);
			break;
		default: 
			fprintf(stderr, "Usage: [-t target]\n",
			   argv[0]);
			exit(EXIT_FAILURE);
		}
  }
  //printf("t = %i\n", target);
    if ( target < 3968 || target > 8000) {
  	fprintf(stderr, "maestro_set: out of range (3969..8000),  target: %i\n" , target);
  	fprintf(stderr, "             did you use the -t <n> option\n");
    } else {
        int position = maestroGetPosition(fd, 0);
        // printf("Current position is %d.\n", position);
        maestroSetTarget(fd, 0, target);
    }
  close(fd);
  exit(EXIT_SUCCESS);
}
