#include <stdio.h>
#include <stdlib.h>
#include <time.h>
#include "workingData.h"

#define timeQuantum 2
#define BUFFER_SIZE 1024
#define MAXJOBS 6
#define sharedArrivals 3
#define sharedBursts 3
#define sharedPriorities 2

/* function declarations */
int handleFCFS(node *jobQueue[], int size);
int handleSJF(node *jobQueue[], int size);
int handleSRTF(node *jobQueue[], int size);
int handleRR(node *jobQueue[], int size);
int handlePriority(node *jobQueue[], int size);

int runFCFS(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess);
int runSJF(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess);
int runSRTF();
int runRR();
int runPriority();

/* global variables */
int validJobs = 0; // initially assumes it is not a valid job queue
int elapsedTime = 0;
linkerHead *universalJobQueue;
linkerHead *readyQueue;
linkerHead *executingProcess;

int choice;

int main(int argc, char *argv[])
{
  choice = 0;
  srand(time(NULL));
  while(choice <= 0 || choice >= 6)
  {
    choice = get_choice();
  }
  //choice = 2;

  char choiceOfAlgorithm[BUFFER_SIZE] = " ";
  if (choice == 1)
  {
    sprintf(choiceOfAlgorithm, "%s", "First Come First Serve");
  }

  else if(choice == 2)
  {
    sprintf(choiceOfAlgorithm, "%s", "Shortest Job First");
  }

  else if(choice == 3)
  {
    sprintf(choiceOfAlgorithm, "%s", "Shortest Remaining Time First");
  }

  else if(choice == 4)
  {
    sprintf(choiceOfAlgorithm, "%s", "Round Robin");
  }

  else
  {
    sprintf(choiceOfAlgorithm, "%s", "Priority");
  }

  send_to_file(choiceOfAlgorithm);

  node *jobQueue[MAXJOBS] = {NULL};

  int emergencyBreak = 0;

  while (!validJobs)
  {
    makeJobs(jobQueue, &validJobs, &emergencyBreak);
  }

  normalizeData(jobQueue);
  char initializerMsg[] = "These are the properties of the nodes before it's being processed by the Algorithms\n";
  send_to_file(initializerMsg);
  for (int i = 0; i < MAXJOBS; i++)
  {
    getNodeProperties(jobQueue[i]);
  }
  char everythingAfterIsProcessed[] = "\nEverything after this line is processed by scheduling Algorithms\n";
  send_to_file(everythingAfterIsProcessed);

  if (choice == 1)
  {
    sortForFCFS(jobQueue, MAXJOBS);
    handleFCFS(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS);
    //for (int i = 0; i < MAXJOBS; i++){getNodeProperties(jobQueue[i]);} //this is to check for whether processes are actually resetted in the .txt file
  }
  else if (choice == 2)
  {
    //sortForSJF(jobQueue, MAXJOBS);
    handleSJF(jobQueue, MAXJOBS);
    resetProcesses(jobQueue, MAXJOBS);
  }
  else if (choice == 3)
  {
    handleSRTF(jobQueue, MAXJOBS);
  }
  else if (choice == 4)
  {
    handleRR(jobQueue, MAXJOBS);
  }
  else
  {
    handlePriority(jobQueue, MAXJOBS);
  }

  // destroying to free up memory
  destroyJobQueue(jobQueue);

  printf("\nEnded\n");

  return 0;
}

int handleFCFS(node *jobQueue[], int size)
{
  /*universalJobQueue = (linkerHead *)malloc(sizeof(linkerHead)); // allocating memory for the queue

  universalJobQueue->head = NULL;

  universalJobQueue->tail = NULL;*/

  readyQueue = (linkerHead *)malloc(sizeof(linkerHead));

  readyQueue->head = NULL;

  readyQueue->tail = NULL;

  executingProcess = (linkerHead *)malloc(sizeof(linkerHead));

  executingProcess->head = NULL;

  executingProcess->tail = NULL;

  runFCFS(jobQueue, size, readyQueue, executingProcess);

  //free(universalJobQueue);
  free(readyQueue);
  free(executingProcess);

  return 0;
}

int runFCFS(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess)
{

  node* readyArr[6] = {NULL}; //init to all NULL
  elapsedTime = 0; //set the elapsedTime to be 0 for the universal CPU execution time
  int processesCompleted = 0;
  int totalTurnAroundTime = 0;
  int totalWaitingTime = 0;
  int totalResponseTime = 0;

  while(processesCompleted < MAXJOBS)
  {   

      //removeDoneJobs(readyArr); //remove any straggler jobs that are already done
      placeArrivedJobs(jobQueue, readyArr, elapsedTime); //continuously places jobs into a readyArray
      sortForFCFS(readyArr, MAXJOBS); //sort the readyArray to be for FCFS
      placeJobs(readyArr, readyLinkedList, size); //the readyLinkedList->tail should be the front most node in the queue to be executed by the CPU

      executingProcess->head = readyLinkedList->tail; //the process to execute for this specific loop is the last item in the readyLinkedList
      
      node* selectedProcess = executingProcess->head; //the process to execute for this specific loop is the last item in the readyLinkedList

      while(selectedProcess->timeLeft == 0)
      {
        selectedProcess = selectedProcess->prevPtr; //get the node that hasn't been finished yet
      }
      node *thisProcess = executingProcess->head;

      thisProcess->responseTime = elapsedTime - thisProcess->arrivalTime; //the time that has already been spent by the CPU executing processes minus off the arrival time of this process

      //retrieving process information to process it by the scheduler
      int burstTime = thisProcess -> burstTime;
      //int arrivalTime = thisProcess -> arrivalTime;

      elapsedTime += burstTime;
      thisProcess->timeLeft = 0; // the job should just finish

      //setting the process's times to the formulas
      thisProcess->turnAroundTime = elapsedTime - (thisProcess->arrivalTime);
      thisProcess->waitingTime = (thisProcess->turnAroundTime) - burstTime;

      printf("Total Time elapsed so far: %d | iter[%d]\n", elapsedTime, processesCompleted);

      //this writes out the process' turnAroundTime etc etc into the txt file
      getNodeProperties(thisProcess);

      //updating the total times to calculate the averages of later on
      totalTurnAroundTime += thisProcess->turnAroundTime;
      totalWaitingTime += thisProcess->waitingTime;
      totalResponseTime += thisProcess->responseTime;
      processesCompleted += 1;
  }
  //after it exits the loop after completing all the processes
  char schedulingType[] = "FCFS";

  writeOutAverageTimes(schedulingType, totalTurnAroundTime, totalWaitingTime, totalResponseTime);

  printf("Total Time elapsed After all processes finished in FCFS: %d\n", elapsedTime);

  return 0;
}

int handleSJF(node *jobQueue[], int size)
{
  readyQueue = (linkerHead *)malloc(sizeof(linkerHead));

  readyQueue->head = NULL;

  readyQueue->tail = NULL;

  executingProcess = (linkerHead *)malloc(sizeof(linkerHead));

  executingProcess->head = NULL;

  executingProcess->tail = NULL;

  runSJF(jobQueue, size, readyQueue, executingProcess);

  free(readyQueue);
  free(executingProcess);

  return 0;
}

int runSJF(node* jobQueue[], int size, linkerHead* readyLinkedList, linkerHead* executingProcess)
{
  node* readyArr[6] = {NULL}; //init to all NULL
  elapsedTime = 0; //set the elapsedTime to be 0 for the universal CPU execution time
  int processesCompleted = 0;
  int totalTurnAroundTime = 0;
  int totalWaitingTime = 0;
  int totalResponseTime = 0;
  while(processesCompleted < MAXJOBS)
  {   
      placeArrivedJobs(jobQueue, readyArr, elapsedTime); //continuously places jobs into a readyArray
      sortForSJF(readyArr, MAXJOBS); //sort the readyArray to be for FCFS
      placeJobs(readyArr, readyLinkedList, size); //the readyLinkedList->tail should be the front most node in the queue to be executed by the CPU

      executingProcess->head = readyLinkedList->tail; 
      
      node* selectedProcess = executingProcess->head; //the process to execute for this specific loop is the last item in the readyLinkedList

      while(selectedProcess->timeLeft == 0)
      {
        selectedProcess = selectedProcess->prevPtr; //get the node that hasn't been finished yet
      }
      
      node *thisProcess = selectedProcess;

      //if (thisProcess == NULL)
      //{
      //  printf("it was a null probably segfaults here %d\n", processesCompleted);
      //}
      //else{
      //  printf("process wasn't NULL %d\n", processesCompleted);
      //}
      if (thisProcess->responseTime == 0)
      {
          thisProcess->responseTime = elapsedTime - thisProcess->arrivalTime; //the time that has already been spent by the CPU executing processes minus off the arrival time of this process
      }

      //retrieving process information to process it by the scheduler
      int burstTime = thisProcess -> burstTime;
      //int arrivalTime = thisProcess -> arrivalTime;

      elapsedTime += burstTime;
      thisProcess->timeLeft = 0; // the job should just finish

      //setting the process's times to the formulas
      thisProcess->turnAroundTime = elapsedTime - (thisProcess->arrivalTime);
      thisProcess->waitingTime = (thisProcess->turnAroundTime) - burstTime;

      //printf("Total Time elapsed so far: %d | iter[%d]\n", elapsedTime, processesCompleted);
      //printf("value before nodeProperties: %d\n", processesCompleted);
      //this writes out the process' turnAroundTime etc etc into the txt file
      getNodeProperties(thisProcess);
      //printf("value after nodeProperties: %d\n", processesCompleted);
      //updating the total times to calculate the averages of later on
      totalTurnAroundTime += thisProcess->turnAroundTime;
      totalWaitingTime += thisProcess->waitingTime;
      totalResponseTime += thisProcess->responseTime;
      processesCompleted += 1;
  }
  char schedulingType[] = "SJF";

  writeOutAverageTimes(schedulingType, totalTurnAroundTime, totalWaitingTime, totalResponseTime);

  printf("Total Time elapsed After all processes finished in SJF: %d\n", elapsedTime);

  return 0;
}
int handleSRTF(node *jobQueue[], int size)
{
  return 0;
}

int handleRR(node *jobQueue[], int size)
{
  return 0;
}

int handlePriority(node *jobQueue[], int size)
{
  return 0;
}